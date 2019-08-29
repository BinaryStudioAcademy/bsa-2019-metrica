<?php

namespace App\Listeners;

use App\Events\VisitCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewVisitsNotification
{
    public function __construct() {}

    public function handle(VisitCreated $event) {}
}
