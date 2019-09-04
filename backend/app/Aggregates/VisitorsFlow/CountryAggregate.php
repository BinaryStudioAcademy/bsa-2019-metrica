<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class CountryAggregate extends Aggregate
{
    public $country;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        ?PageValue $nextPage,
        ?PageValue $prevPage,
        int $views,
        int $level,
        bool $isLastPage,
        string $country
    )
    {
        parent::__construct($id, $websiteId, $url, $title,$nextPage, $prevPage, $views, $level, $isLastPage);
        $this->country = $country;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['country' => $this->country]);
    }

    public static function fromResult(array $result): self
    {
        return new self(
            (int)$result['id'],
            (int)$result['websiteId'],
            (string)$result['url'],
            (string)$result['title'],
            $result['nextPage'] === null ? null : new PageValue(
                (int)$result['nextPage']['id'],
                (string)$result['nextPage']['url']
            ),
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            ),
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['isLastPage'],
            (string)$result['country']
        );
    }
}
