<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\Visits\VisitCreated;
use App\Listeners\Visits\CreateVisitAggregate;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VisitCreated::class => [
            CreateVisitAggregate::class,
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
