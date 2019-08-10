<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Session extends Model
{
    protected $fillable = [
        'start_session',
        'end_session',
        'visitor_id',
        'entrance_page_id',
        'demographic_id',
        'device_id',
        'system_id',
    ];

    protected $with = ['visitors', 'pages', 'demographic', 'devices', 'systems'];
}
