<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

final class ElasticsearchVisitorFlowCountryRepository implements VisitorFlowCountryRepository
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
            'body' => $countryAggregate->toArray()
        ]);

        return $countryAggregate;
    }

    public function getByParams(int $websiteId, string $url, int $level):?CountryAggregate
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['websiteId' => $websiteId]],
                        ],
                        'filter' => [
                            ['term' => ['level' => $level]],
                            ['match_phrase' => ['url' => $url]],
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
        return CountryAggregate::fromResult($result['hits']['hits'][0]['_source']);
    }

}
