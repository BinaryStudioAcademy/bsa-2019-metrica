<?php

declare(strict_types=1);

namespace App\Entities;

use App\Notifications\MailSuccessRegistrationNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\MailResetPasswordNotification;

final class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_activate'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['websites'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function websites()
    {
        return $this->belongsToMany(Website::class)->withPivot('role');
    }

    public function isWebsiteOwner(int $websiteId)
    {
        $userWebsite = auth()->user()
                            ->websites()
                            ->wherePivot('website_id', '=', $websiteId)
                            ->wherePivot('role', '=', 'owner')
                            ->first();

        return $userWebsite ? true : false;
    }

}
