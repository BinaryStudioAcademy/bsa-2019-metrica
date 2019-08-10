<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class System extends Model
{
    protected $fillable = [
        'browser_id',
        'os_id',
        'screen_resolution',
    ];

    protected $with = ['browsers', 'os'];
}
