<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class DeviceAggregate extends Aggregate
{
    public $device;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        string $device,
        ?PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $prevPage);
        $this->$device = $device;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['device' => $this->device]);
    }

    public static function fromResult(array $result): self
    {
        return new self(
            (int)$result['id'],
            (int)$result['websiteId'],
            (string)$result['url'],
            (string)$result['title'],
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['isLastPage'],
            (string)$result['device'],
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }
}
