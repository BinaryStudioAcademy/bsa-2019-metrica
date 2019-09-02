<?php

namespace App\Actions\System;

use Illuminate\Support\Collection;

class GetDeviceTypeStatsResponse
{
    private $devices;

    public function __construct(Collection $devices)
    {
        $this->devices = $devices;
    }

    public function getDevicesStats(): Collection
    {
        return $this->devices;
    }
}
