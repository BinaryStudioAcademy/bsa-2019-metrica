<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Role extends Model
{
    protected $table = 'roles';

    protected $guarded = ['type'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}