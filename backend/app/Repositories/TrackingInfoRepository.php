<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\TrackingInfo;
use App\Repositories\Contracts\EloquentTrackingInfoRepository;
use Illuminate\Support\Facades\Auth;

final class TrackingInfoRepository implements EloquentTrackingInfoRepository
{

    public function save(TrackingInfo $trackingInfo): TrackingInfo
    {
        $trackingInfo->tracking_id = $this->generateTrackingNumber();

        $trackingInfo->save();

        return $trackingInfo;
    }

    private function generateTrackingNumber()
    {
        $result = '';

        for($i = 0; $i < 8; $i++) {
            $result .= random_int(0, 9);
        }

        return $result . '-' . Auth::id();
    }
}
