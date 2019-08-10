<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Browser extends Model
{
    protected $fillable = ['name'];
}
