<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\AppInvalidArgumentException;
use DateTime;

final class DatePeriod implements \App\Contracts\Common\DatePeriod
{
    private $startDate;
    private $endDate;

    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public static function createFromTimestamp($start, $end): self
    {
        try {
            $startDate = new DateTime('@' . $start);
            $endDate = new DateTime('@' . $end);
            return new static($startDate, $endDate);
        } catch (\Exception $e) {
            throw new AppInvalidArgumentException($e->getMessage());
        }
    }
}
