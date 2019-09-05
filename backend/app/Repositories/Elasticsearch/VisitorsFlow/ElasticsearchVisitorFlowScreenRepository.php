<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\Aggregates\VisitorsFlow\ScreenAggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

class ElasticsearchVisitorFlowScreenRepository implements VisitorFlowScreenRepository
{
    const INDEX_NAME = 'screen-visitors-flow';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $screenAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $screenAggregate->getId(),
            'type' => '_doc',
            'body' => $screenAggregate->toArray()
        ]);

        return $screenAggregate;
    }

    public function update(Aggregate $screenAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $screenAggregate->getId(),
            'type' => '_doc',
            'body' => $screenAggregate->toArray()
        ]);

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
                            ['match' => ['websiteId' => $criteria->websiteId]],
                        ],
                        'filter' => [
                            ['term' => ['level' => $criteria->level]],
                            ['match_phrase' => ['resolution_width' => $criteria->resolutionWidth]],
                            ['match_phrase' => ['resolution_height' => $criteria->resolutionHeight]],
                            ['match_phrase' => ['url' => $criteria->url]],
                            ['match_phrase'=>['prevPage.url'=>$criteria->prevPageUrl]]
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
        return ScreenAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }
}
