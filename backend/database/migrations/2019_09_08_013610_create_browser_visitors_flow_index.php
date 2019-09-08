<?php

use Illuminate\Database\Migrations\Migration;

class CreateBrowserVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'browser-visitors-flow-index';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $client = app('elasticsearch');
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    "properties" => [
                        "browser" => [
                            "type" => "keyword"
                        ]
                    ]
                ]
            ]
        ];
        $client->indices()->create($params);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $client = app('elasticsearch');
        $params = ['index' => self::INDEX_NAME];
        $client->indices()->delete($params);
    }
}
