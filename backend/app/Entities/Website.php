<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Website extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'single_page',
        'user_id',
        'tracking_info_id',
    ];

    protected $with = ['tracking_info', 'users'];
}
