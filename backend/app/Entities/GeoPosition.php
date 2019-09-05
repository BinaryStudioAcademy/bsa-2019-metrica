<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GeoPosition
 * @package App\Entities
 * @property int $id
 * @property string $country
 * @property string $city
 */
final class GeoPosition extends Model
{
    protected $fillable = [
        'country',
        'city',
    ];

    public function visits()
    {
        return $this->hasMany(Session::class);
    }
}
