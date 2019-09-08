<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountryVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'country-visitors-flow-index';

    public function up()
    {
        $client = app('elasticsearch');
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    "properties" => [
                        "country" => [
                            "type" => "keyword"
                        ]
                    ]
                ]
            ]
        ];

        $client->indices()->create($params);
    }

    public function down()
    {
        $client = app('elasticsearch');
        $params = ['index' => self::INDEX_NAME];
        $client->indices()->delete($params);
    }
}
