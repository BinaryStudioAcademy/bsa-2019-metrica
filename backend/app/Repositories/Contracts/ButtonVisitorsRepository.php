<?php


namespace App\Repositories\Contracts;

interface ButtonVisitorsRepository
{
    public function getVisitorsCount(string $startData, string $endData, int $websiteId, int $userId): int;
}
