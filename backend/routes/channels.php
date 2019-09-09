<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Entities\Website;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('active-users.{website_id}', function ($user, $website_id) {
    return (int)$user->website->id === (int)$website_id;
});

Broadcast::channel('stats.{website_id}', function ($user, $website_id) {
    return (int) $user->id === (int) Website::find($website_id)->user->id;
});
