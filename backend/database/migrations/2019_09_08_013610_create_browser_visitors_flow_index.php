<?php

use Illuminate\Database\Migrations\Migration;

class CreateBrowserVisitorsFlowIndex extends Migration
{
    private const INDEX_NAME = 'browser-visitors-flow-index';
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
                        "browser" => [
                            "type" => "keyword"
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
