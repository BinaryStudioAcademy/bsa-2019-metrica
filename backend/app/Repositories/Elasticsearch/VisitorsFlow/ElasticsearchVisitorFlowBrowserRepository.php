<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

class ElasticsearchVisitorFlowBrowserRepository implements VisitorFlowBrowserRepository
{
    const INDEX_NAME = 'browser-visitors-flow-index';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $browserAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $browserAggregate->getId(),
            'type' => '_doc',
            'body' => $browserAggregate->toArray()
        ]);

        return $browserAggregate;
    }

    public function getByCriteria(Criteria $criteria): ?BrowserAggregate
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['website_id' => $criteria->websiteId]],
                        ],
                        'filter' => [
                            ['term' => ['level' => $criteria->level]],
                            ['match_phrase' => ['target_url' => $criteria->targetUrl]],
                            ['match_phrase' => ['parameter' => $criteria->parameter]],
                            ['match_phrase' => ['prev_page.source_url' => $criteria->prevPageUrl]]
                        ],
                    ]
                ]
            ]
        ];
        try {
            $result = $this->client->search($params);
        } catch (\Exception $exception) {
            return null;
        }
        if (empty($result['hits']['hits'])) {
            return null;
        }
        return BrowserAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }

    public function getViewsByEachBrowser(string $type, int $websiteId): ParametersCollection
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['website_id' => $websiteId]],
                        ]
                    ]
                ],
                'aggregations' => [
                    'browsers' => [
                        'terms' => [
                            'field' => 'parameter'
                        ],
                        'aggregations' => [
                            'views' => [
                                'sum' => [
                                    'field' => 'views'
                                ]
                            ]
                        ]
                    ]
                ]
            ]

        ];
        $result = $this->client->search($params);
        return new ParametersCollection($result['aggregations']['browsers']['buckets']);
    }

    public function getFlow(int $websiteId, int $level): ParameterFlowCollection
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['website_id' => $websiteId]],
                        ],
                        'filter' => [
                            $level > 2 ? ['term' => ['level' => $level]] : [
                                'range' => [
                                    "level" => [
                                        'gte' => 1,
                                        'lte' => 2
                                    ]
                                ]
                            ],
                        ]
                    ]
                ],
                'sort' => [
                   [ 'level' => ['order' => 'asc', "unmapped_type" => "integer"]],
                   [ 'views' => ['order' => 'desc',  "unmapped_type" => "integer"]]
                ]
            ]
        ];
        $result = $this->client->search($params);
        return new ParameterFlowCollection($result['hits']['hits']);
    }
}


