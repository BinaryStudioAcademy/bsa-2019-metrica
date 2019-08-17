<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Visit extends Model
{
    protected $fillable = [
        'visit_time',
        'ip_address',
        'session_id',
        'page_id',
        'visitor_id'
    ];

    protected $with = ['session', 'pages', 'visitors'];
}
