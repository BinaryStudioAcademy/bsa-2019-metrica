<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\TrackingInfo;
use App\Repositories\Contracts\EloquentTrackingInfoRepository;

final class TrackingInfoRepository implements EloquentTrackingInfoRepository
{

    public function save(TrackingInfo $trackingInfo): TrackingInfo
    {
        $trackingInfo->save();

        return $trackingInfo;
    }
}
