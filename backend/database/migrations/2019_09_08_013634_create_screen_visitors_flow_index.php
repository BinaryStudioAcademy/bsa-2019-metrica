<?php

use Illuminate\Database\Migrations\Migration;

class CreateScreenVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'screen-visitors-flow-index';

    public function up()
    {
        $this->down();
        $client = app('elasticsearch');
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    "properties" => [
                        "resolution_width" => [
                            "type" => "integer"
                        ],
                        "resolution_height" => [
                            "type" => "integer"
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
