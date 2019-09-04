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
        int $views,
        int $level,
        bool $isLastPage,
        string $country,
        ?PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $prevPage);
        $this->country = $country;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['country' => $this->country]);
    }

    public static function fromResult(array $result): Aggregate
    {
        return new static(
            (int)$result['id'],
            (int)$result['websiteId'],
            (string)$result['url'],
            (string)$result['title'],
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['isLastPage'],
            (string)$result['country'],
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }
}
