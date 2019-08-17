<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class System extends Model
{
    protected $fillable = [
        'name',
        'os',
        'browser',
        'device',
        'resolution_width',
        'resolution_height'
    ];
}
