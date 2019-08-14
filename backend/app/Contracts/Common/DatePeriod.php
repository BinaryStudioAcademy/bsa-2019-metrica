<?php


namespace App\Contracts\Common;


interface DatePeriod
{
    public function getStartDate(): \DateTime;
    public function getEndDate(): \DateTime;
}
