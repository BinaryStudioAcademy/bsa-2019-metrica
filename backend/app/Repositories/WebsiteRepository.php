<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\EloquentWebsiteRepository;
use Illuminate\Support\Facades\DB;

final class WebsiteRepository implements EloquentWebsiteRepository
{
    public function save(Website $website): Website
    {
        $website->tracking_number = $this->getLastTrackingNumber();

        $website->save();

        return $website;
    }

    private function getLastTrackingNumber(): int
    {
        $lastTrackingNumber = DB::table('websites')->latest('tracking_number')->first() ?? 1;
    }
}
