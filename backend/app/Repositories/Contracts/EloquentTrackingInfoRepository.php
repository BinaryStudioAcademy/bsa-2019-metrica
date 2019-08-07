<?php
declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\TrackingInfo;

interface EloquentTrackingInfoRepository
{
    public function save(TrackingInfo $trackingInfo): TrackingInfo;
}
