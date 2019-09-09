<?php

use Illuminate\Database\Migrations\Migration;

class CreateDeviceVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'device-visitors-flow-index';

    public function up()
    {
        $this->down();
        $client = app('elasticsearch');
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    "properties" => [
                        "device" => [
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
        if ($client->indices()->exists($params)) {
            $client->indices()->delete($params);
        }
    }
}
