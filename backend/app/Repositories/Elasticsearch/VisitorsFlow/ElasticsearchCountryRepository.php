<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\CountryRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

final class ElasticsearchCountryRepository implements CountryRepository
{
    const INDEX_NAME = 'country-visitors-flow';
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
            'body' => [
                'doc' => $countryAggregate->toArray()
            ]
        ]);

        return $countryAggregate;
    }

    public function getById(int $id): CountryAggregate
    {
//        $result = $this->client->get([
//            'index' => self::INDEX_NAME,
//            'type' => '_doc',
//            'id' => $id
//        ]);
//        return CountryAggregate::fromResult($result['_source']);
    }

    public function getByParams(int $websiteId, string $url, int $level)
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['websiteId' => $websiteId]],
                            ['match' => ['level' => $level]],
                            ['match' => ['url' => $url]],
                        ]
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
        //доделать!!!!!
        return CountryAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }

}
