<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class Visit extends Model
{
    public $date;
    public $visits;
    protected $fillable = [
        'visit_time',
        'ip_address',
        'session_id',
        'page_id',
        'visitor_id',
        'device_id',
    ];

    protected $with = ['session', 'pages', 'visitors', 'devices'];

    public static function modelsFromRawResults($rawResult = [])
    {
        $objects = [];

        foreach($rawResult as $result)
        {
            $object = new static();

            $object->setRawAttributes((array)$result, true);

            $objects[] = $object;
        }

        return new Collection($objects);
    }
}
