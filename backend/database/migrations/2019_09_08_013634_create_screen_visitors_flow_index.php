<?php

use Illuminate\Database\Migrations\Migration;

class CreateScreenVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'screen-visitors-flow-index';
    private $client;

    public function __construct()
    {
        $this->client =  app('elasticsearch');
    }
    public function up()
    {
        $this->down();
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
        $this->client->indices()->create($params);
    }

    public function down()
    {
        $params = ['index' => self::INDEX_NAME];
        if ($this->client->indices()->exists($params)) {
            $this->client->indices()->delete($params);
        }
    }
}
