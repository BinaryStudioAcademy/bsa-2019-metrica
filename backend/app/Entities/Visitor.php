<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Visitor extends Model
{
    protected $fillable = [
        'visitor_type',
        'website_id',
    ];

    protected $with = ['websites'];
}
