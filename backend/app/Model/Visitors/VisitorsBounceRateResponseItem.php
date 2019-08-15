<?php


namespace App\Model\Visitors;


class VisitorsBounceRateResponseItem
{
    private $timeStamp;
    private $rate;

    public function __construct(int $timeStamp, float $rate)
    {
        $this->timeStamp = $timeStamp;
        $this->rate = $rate;
    }

    public function getTimeStamp(): int
    {
        return $this->timeStamp;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
