<?php

declare(strict_types=1);

namespace App\Repositories\Elasticsearch\PageViews;

use App\Aggregates\PageViews\TableAggregate;
use App\Aggregates\Contracts\Aggregate;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

final class ElasticsearchTableRepository
{
    const INDEX_NAME = 'page-views-table';
    private $client;

    public function __construct(ElasticsearchManager $client)
    {
        $this->client = $client;
    }

    public function save(Aggregate $tableAggregate): Aggregate
    {
        $this->client->index([
            'index' => self::INDEX_NAME,
            'id' => $tableAggregate->getId(),
            'type' => '_doc',
            'body' => $tableAggregate->toArray()
        ]);

        return $tableAggregate;
    }

    public function getById(int $id): TableAggregate
    {
        $result = $this->client->get([
            'index' => self::INDEX_NAME,
            'type' => '_doc',
            'id' => $id
        ]);

        return TableAggregate::fromResult($result['_source']);
    }
}