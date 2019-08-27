<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ButtonVisitsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testGetUniquePageViews()
    {
        $this->getUniquePageViewsSeed();
        $filterData = [
            'filter' => [
                'startDate' => (string)Carbon::parse('2019-08-21 00:00:00', 'UTC')->getTimestamp(),
                'endDate' => (string)Carbon::parse('2019-08-22 00:00:00', ' UTC')->getTimestamp(),
            ]
        ];
        $expectedData = [
            'data' => [
                'value' => '7'
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/button-page-views/unique', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function getUniquePageViewsSeed()
    {
        factory(Website::class)->create();
        factory(Visitor::class, 5)->create();
        factory(System::class)->create();
        factory(Page::class, 6)->create();
        factory(GeoPosition::class)->create();

        $firstSession = factory(Session::class)->create([
            'start_session' => '2019-08-21 00:00:00',
            'end_session' => '2019-08-22 00:00:00',
            'entrance_page_id' => 1
        ]);

        $pageIds = [1, 2, 3];
        for ($i = 0, $hours = 0; $i < 4; $i++, $hours += 1) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-21'))->addHours($hours)
                    ->toDateTimeString(),
                'session_id' => $firstSession->id,
                'page_id' => $pageIds[$i % 3]
            ]);
        }

        $secondSession = factory(Session::class)->create([
            'start_session' => '2019-08-21 00:00:00',
            'end_session' => '2019-08-22 00:00:00',
            'entrance_page_id' => 2
        ]);

        $pageIds = [2, 3];
        for ($i = 0, $hours = 0; $i < 4; $i++, $hours += 2) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-21'))->addHours($hours)
                    ->toDateTimeString(),
                'session_id' => $secondSession->id,
                'page_id' => $pageIds[$i % 2]
            ]);
        }

        $thirdSession = factory(Session::class)->create([
            'start_session' => '2019-08-21 00:00:00',
            'end_session' => '2019-08-24 00:00:00',
            'entrance_page_id' => 2
        ]);

        $pageIds = [1, 2, 3, 4];
        for ($i = 0, $days = 0; $i < 4; $i++, $days++) {
            factory(Visit::class)->create([
                'visit_time' => (Carbon::parse('2019-08-21 00:00:00', 'UTC'))->addDays($days)
                    ->toDateTimeString(),
                'session_id' => $thirdSession->id,
                'page_id' => $pageIds[$i]
            ]);
        }
    }
}


