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
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ChartVisitsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testGetUniquePageViewsChart()
    {
        $this->getUniquePageViewsChartSeed();
        $filterData = [
            'filter' => [
                'startDate' => (string)Carbon::parse('2019-08-21 00:00:00', 'UTC')->getTimestamp(),
                'endDate' => (string)Carbon::parse('2019-08-22 00:00:00', ' UTC')->getTimestamp(),
                'period' => 21600,
                'website_id' => $this->website->id
            ]
        ];
        $expectedData = [
            'data' => [
                ['date' => (string)Carbon::parse('2019-08-21 00:00:00', 'UTC')->getTimestamp(),
                    'value' => '7'
                ],
                ['date' => (string)Carbon::parse('2019-08-21 06:00:00', 'UTC')->getTimestamp(),
                    'value' => '3'
                ],
                ['date' => (string)Carbon::parse('2019-08-22 00:00:00', 'UTC')->getTimestamp(),
                    'value' => '1'
                ]
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-visits/unique', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function getUniquePageViewsChartSeed()
    {
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        factory(Page::class, 4)->create();
        factory(Visitor::class, 5)->create();
        factory(System::class)->create();

        factory(GeoPosition::class)->create();

        $pageIds = DB::select("SELECT id FROM \"pages\"");
        [$page1,$page2,$page3,$page4] = $pageIds;
        $firstSession = factory(Session::class)->create([
            'start_session' => '2019-08-21 00:00:00',
            'end_session' => '2019-08-22 00:00:00',
        ]);

        $pageIds = [$page1->id, $page2->id, $page3->id];
        for ($i = 0, $hours = 0; $i < 6; $i++, $hours += 1) {
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
        ]);

        $pageIds = [$page2->id, $page3->id, $page4->id];
        for ($i = 0, $hours = 0; $i < 6; $i++, $hours += 2) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-21'))->addHours($hours)
                    ->toDateTimeString(),
                'session_id' => $secondSession->id,
                'page_id' => $pageIds[$i % 3]
            ]);
        }

        $thirdSession = factory(Session::class)->create([
            'start_session' => '2019-08-20 00:00:00',
            'end_session' => '2019-08-24 00:00:00',
        ]);

        $pageIds = [$page1->id,$page2->id,$page3->id,$page4->id];
        for ($i = 0, $days = 0; $i < 4; $i++, $days++) {
            factory(Visit::class)->create([
                'visit_time' => (Carbon::parse('2019-08-20 00:00:00', 'UTC'))->addDays($days)
                    ->toDateTimeString(),
                'session_id' => $thirdSession->id,
                'page_id' => $pageIds[$i]
            ]);
        }
    }
}
