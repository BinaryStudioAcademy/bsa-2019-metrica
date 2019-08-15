<?php


namespace App\Actions\Visitors;


class GetNewVisitorsByDateRangeResponse
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

}
