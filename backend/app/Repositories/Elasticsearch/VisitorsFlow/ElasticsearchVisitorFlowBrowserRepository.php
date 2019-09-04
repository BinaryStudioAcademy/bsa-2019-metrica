<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

class ElasticsearchVisitorFlowBrowserRepository implements VisitorFlowBrowserRepository
{
    const INDEX_NAME = 'browser-visitors-flow';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $countryAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $countryAggregate->getId(),
            'type' => '_doc',
            'body' => $countryAggregate->toArray()
        ]);

        return $countryAggregate;
    }

    public function update(Aggregate $countryAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $countryAggregate->getId(),
            'type' => '_doc',
            'body' => $countryAggregate->toArray()
        ]);

        return $countryAggregate;
    }



    public function getByCriteria(Criteria $criteria): ?BrowserAggregate
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
                            ['match_phrase' => ['url' => $criteria->url]],
                            ['match_phrase' => ['browser' => $criteria->browser]],

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
}
