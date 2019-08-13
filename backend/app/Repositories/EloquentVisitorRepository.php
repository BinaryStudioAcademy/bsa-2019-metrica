<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentVisitorRepository implements VisitorRepository
{
    public function all(): Collection
    {
        return Visitor::all();
    }

    public function countAll(): int
    {
        return Visitor::count();
    }

    public function newest(): Collection
    {
        return new Collection();
    }

    public function countSinglePageInactiveSessionBetweenDate(string $from, string $to): int
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($from, $to) {
                $query->whereDateBetween($from, $to)
                    ->has('visits', '=', '1')
                    ->inactive();
            })
            ->count();
    }
}