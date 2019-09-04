<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class ScreenAggregate extends Aggregate
{
    public $resolutionWidth;
    public $resolutionHeight;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $resolutionWidth,
        int $resolutionHeight,
        ?PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $prevPage);
        $this->resolutionWidth = $resolutionWidth;
        $this->resolutionHeight = $resolutionHeight;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'resolution_width' => $this->resolutionWidth,
            'resolution_height' => $this->resolutionHeight
        ]);
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
            (int)$result['resolution_width'],
            (int)$result['resolution_height'],
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }
}
