<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Language extends Model
{
    protected $fillable = [
        'language',
    ];
}
