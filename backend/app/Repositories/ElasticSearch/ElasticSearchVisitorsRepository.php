<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch;

use App\Entities\Visitor;
use Cviebrock\LaravelElasticsearch\Manager as ElasticsearchManager;

final class ElasticSearchVisitorsRepository
{
	private $client;

	public function __construct(ElasticsearchManager $client)
	{
		$this->client = $client;
	}

	public function save(Visitor $visitor)
	{
		$website = $visitor->website;

		$this->client->index([
			'index' => 'visitors',
			'id' => $visitor->id,
			'type' => 'docs',
			'body' => [
				'id' => $visitor->id,
				'last_activity' => $visitor->last_activity,
				'website' => [
					'name' => $website->name,
					'domain' => $website->domain,
					'user_id' => $website->user_id,
					'tracking_number' => $website->tracking_number,
				]
			]
		]);
	}
}