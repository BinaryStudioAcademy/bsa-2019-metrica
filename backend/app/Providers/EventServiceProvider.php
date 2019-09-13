<?php

namespace App\Providers;

use App\Events\UpdatePrevious;
use App\Listeners\CreateVisitAggregate;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\VisitCreated' => [
            'App\Listeners\SendVisitsNotification',
            CreateVisitAggregate::class,
        ],
        'App\Events\SessionCreated' => [
            'App\Listeners\SendSessionNotification'
        ],
        UpdatePrevious::class=>[
            \App\Listeners\UpdatePrevious::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
