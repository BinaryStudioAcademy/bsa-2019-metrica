<?php
declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePrevious implements ShouldQueue
{

    public function handle(\App\Events\UpdatePrevious $event)
    {
        $event->repository->save($event->aggregate);
    }
}
