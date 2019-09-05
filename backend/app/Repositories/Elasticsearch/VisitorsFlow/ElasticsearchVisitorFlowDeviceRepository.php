<?php


namespace App\Repositories\Elasticsearch\VisitorsFlow;


use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\DeviceAggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowDeviceRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

class ElasticsearchVisitorFlowDeviceRepository implements VisitorFlowDeviceRepository
{
    const INDEX_NAME = 'device-visitors-flow';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $deviceAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $deviceAggregate->getId(),
            'type' => '_doc',
            'body' => $deviceAggregate->toArray()
        ]);

        return $deviceAggregate;
    }

    public function update(Aggregate $deviceAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $deviceAggregate->getId(),
            'type' => '_doc',
            'body' => $deviceAggregate->toArray()
        ]);

        return $deviceAggregate;
    }


    public function getByCriteria(Criteria $criteria): ?DeviceAggregate
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
                            ['match_phrase' => ['device' => $criteria->device]],
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
        return DeviceAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }
}
