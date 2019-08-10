<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Page extends Model
{
    protected $fillable = [
        'name',
        'url',
        'previews',
        'website_id',
    ];

    protected $with = ['websites'];
}
