<?php

namespace App\Events;

use App\Entities\Session;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Event;

class SessionCreated extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }
}
