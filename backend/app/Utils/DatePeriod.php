<?php


namespace App\Utils;


use App\Exceptions\AppInvalidArgumentException;

class DatePeriod implements \App\Contracts\Common\DatePeriod
{

    private $startDate;
    private $endDate;

    /**
     * @throws AppInvalidArgumentException
     */
    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        if ($startDate > $endDate){
            throw  new AppInvalidArgumentException('Start date can\'t be greater then end date');
        }
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @throws AppInvalidArgumentException
     */
    public static function createFromTimestamp($start, $end): self
    {
        try {
            $startDate = new \DateTime('@' . $start);
            $endDate = new \DateTime('@' . $end);
            return new static($startDate, $endDate);
        } catch(\Exception $e) {
            throw new AppInvalidArgumentException($e->getMessage());
        }
    }
}
