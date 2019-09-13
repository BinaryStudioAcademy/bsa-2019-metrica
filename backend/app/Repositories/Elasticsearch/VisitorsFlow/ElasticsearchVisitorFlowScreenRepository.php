<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\ScreenAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;
use App\DataTransformer\VisitorsFlow\ScreenFlowCollection;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;
use Illuminate\Support\Facades\Log;

class ElasticsearchVisitorFlowScreenRepository implements VisitorFlowScreenRepository
{
    const INDEX_NAME = 'screen-visitors-flow-index';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $screenAggregate): Aggregate
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $screenAggregate->getId(),
            'type' => '_doc',
            'body' => $screenAggregate->toArray()
        ];
        Log::info(json_encode($params, JSON_PRETTY_PRINT));
        $this->client->index($params);

        return $screenAggregate;
    }

    public function getByCriteria(Criteria $criteria): ?ScreenAggregate
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
                            ['match_phrase' => ['resolution_width' => $criteria->resolutionWidth]],
                            ['match_phrase' => ['resolution_height' => $criteria->resolutionHeight]],
                            ['match_phrase' => ['target_url' => $criteria->targetUrl]],
                            ['match_phrase' => ['prev_page.source_url' => $criteria->prevPageUrl]]
                        ],
                    ]
                ]
            ]
        ];
        Log::info(json_encode($params, JSON_PRETTY_PRINT));
        try {
            $result = $this->client->search($params);
        } catch (\Exception $exception) {
            return null;
        }
        if (empty($result['hits']['hits'])) {
            return null;
        }
        return ScreenAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }

    public function getViewsByEachScreen(int $websiteId): ParametersCollection
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
                    'resolutions' => [
                        'terms' => [
                            'script' => "doc['resolution_width'].value + 'х' + doc['resolution_height'].value"
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
        Log::info(json_encode($params, JSON_PRETTY_PRINT));
        $result = $this->client->search($params);
        return new ParametersCollection($result['aggregations']['resolutions']['buckets']);
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
        Log::info(json_encode($params, JSON_PRETTY_PRINT));
        $result = $this->client->search($params);
        return new ScreenFlowCollection($result['hits']['hits']);
    }
}
