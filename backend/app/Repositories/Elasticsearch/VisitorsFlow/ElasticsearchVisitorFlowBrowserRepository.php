<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\DataTransformer\VisitorsFlow\BrowserFlowCollection;
use App\DataTransformer\VisitorsFlow\BrowsersCollection;
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

    public function update(Aggregate $browserAggregate): Aggregate
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
                            ['match_phrase' => ['browser' => $criteria->browser]],
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

    public function getViewsByEachBrowser(string $type, int $websiteId): BrowsersCollection
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
                            'field' => $type
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
        return new BrowsersCollection($result['aggregations']['browsers']['buckets']);
    }

    public function getFlow(int $websiteId): BrowserFlowCollection
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
                'sort' => [
                    'level' => 'asc',
                    'views' => 'desc'
                ]
            ]
        ];
        $result = $this->client->search($params);
        return new BrowserFlowCollection($result['hits']['hits']);
    }
}


