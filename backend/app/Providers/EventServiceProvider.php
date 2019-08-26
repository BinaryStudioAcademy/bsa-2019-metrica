<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\Visitors\VisitorCreated;
use App\Listeners\Visitors\CreateVisitorAggregate;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VisitorCreated::class => [
            CreateVisitorAggregate::class,
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
