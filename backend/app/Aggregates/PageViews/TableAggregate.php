<?php

declare(strict_types=1);

namespace App\Aggregates\PageViews;

use App\Aggregates\PageViews\Values\PageValue;
use App\Aggregates\Contracts\Aggregate;
use Carbon\Carbon;
use App\Entity\{
	Visit,
	Page,
	Website
};

final class TableAggregate implements Aggregate
{
	private $id;
	public $websiteId;
	public $createdAt;
	public $updatedAt;
	public $isLast;
	public $isOneInSession;
	public $page;

	public function __construct(
		int $id,
		int $websiteId,
		Carbon $createdAt,
		Carbon $updatedAt,
		bool $isLast,
		bool $isOneInSession,
		PageValue $page
	) {
		$this->id = $id;
		$this->websiteId = $websiteId;
		$this->createdAt = $createdAt;
		$this->updatedAt = $updatedAt;
		$this->isLast = $isLast;
		$this->isOneInSession = $isOneInSession;
		$this->page = $page;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'websiteId' => $this->websiteId,
			'created_at' => $this->createdAt,
			'updated_at' => $this->updatedAt,
			'page' => [
				'id' => $this->page->id,
				'url' => $this->page->url,
				'title' => $this->page->title,
				'created_at' => $this->page->createdAt
			],
			'isLast' => $this->isLast,
			'isOneInSession' => $this->isOneInSession
		];
	}

	public static function fromResult(array $result)
	{
		return new self(
			(int) $result['id'],
			(int) $result['websiteId'],
			new Carbon($result['created_at']),
			new Carbon($result['updated_at']),
			(bool) $result['isLast'],
			(bool) $result['isOneInSession'],
			new PageValue(
				(int) $result['page']['id'],
				(string) $result['page']['url'],
				(string) $result['page']['title'],
				new Carbon($result['page']['created_at'])
			)
		);
	}
}
