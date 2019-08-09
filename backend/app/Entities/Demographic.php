<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Demographic extends Model
{
    protected $fillable = [
        'language',
        'geo_position_id',
    ];
}
