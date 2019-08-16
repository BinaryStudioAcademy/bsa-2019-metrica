<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Entities\Website;
use App\Entities\Visitor;
use App\Entities\Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Repositories\EloquentSessionRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class CountSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_count_sessions()
    {
        $user = factory(User::class)->create();
        $website = factory(Website::class)->create();
        $user->website()->save($website);
        $token = JWTAuth::fromUser($user);
        $websiteVisitors = factory(Visitor::class, 10)->create(['website_id' => $website->id]);
        $start_session = Carbon::now();


        $geoPositionId = factory(\App\Entities\GeoPosition::class)->create()->id;
        $oSId = factory(\App\Entities\Os::class)->create()->id;
        $browserId = factory(\App\Entities\Browser::class)->create()->id;
        $pageId = factory(\App\Entities\Page::class)->create(['website_id' => $website->id])->id;
        $demographicId = factory(\App\Entities\Demographic::class)->create(['geo_position_id' => $geoPositionId])->id;
        $deviceId = factory(\App\Entities\Device::class)->create()->id;
        $systemId = factory(\App\Entities\System::class)->create([
            'browser_id' => $browserId,
            'os_id' => $oSId
        ])->id;

        factory(Session::class, 30)->create([
            'visitor_id' => $websiteVisitors->pluck('id')->random(),
            'start_session' => $start_session->addDays(rand(0, 4))->toDateTimeString(),
            'end_session' => $start_session->addSeconds(100)->toDateTimeString(),
            'entrance_page_id' => $pageId,
            'demographic_id' => $demographicId ,
            'device_id' => $deviceId ,
            'system_id' => $systemId
        ]);

        $queryString = '?filter[startDate]='.Carbon::now()->timestamp.'&filter[endDate]='.Carbon::now()->addDays(5)->timestamp;

        $this->actingAs($user)
            ->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/v1/sessions/count/'.$queryString)
            ->assertOk()
            ->assertJsonStructure([
                    'data' => [
                        'qty_sessions'
                    ],
                    'meta',
               ]);
    }
}


