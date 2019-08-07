<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class TrackingInfo extends Model
{
    protected $table = "tracking_info";

    protected $fillable = ['tracking_id'];
}
