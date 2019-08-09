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
        $website->tracking_number = $this->getLastTrackingNumber() + 1;

        $website->save();

        return $website;
    }

    private function getLastTrackingNumber(): int
    {
        $last = DB::table('websites')->latest()->first();

        return $last ? $last->tracking_number : 0;
    }
}
