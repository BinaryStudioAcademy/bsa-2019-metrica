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
    private $website;

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
                'website_id' => $this->website->id
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
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);

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

    public function testGetBounceRatePageViews()
    {
        $endpoint = 'api/v1/button-page-views/bounce-rate';
        $startDate = new \DateTime('2019-08-20 06:00:00');
        $endDate = new \DateTime('2019-08-20 07:30:00');

        $website = factory(Website::class)->create();
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
        factory(Visitor::class)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Page::class)->create(['id' => 11]);
        factory(Page::class)->create(['id' => 12]);
        factory(Page::class)->create(['id' => 13]);
        factory(Page::class)->create(['id' => 14]);
        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'website_id' => $website->id
            ]
        ];
        $this->createVisitWithSessions(new \DateTime('2019-08-20 05:30:00'), [14]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:10:00'), [12]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:20:00'), [11,13,12]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:30:00'), [12,14]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:30:00'), [11]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:50:00'), [14,12]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 07:10:00'), [11,14]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 07:30:00'), [13]);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 08:30:00'), [11]);

        $expectedData = [
            'data' => [
                'value' => "0.25",
            ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }
    private function createVisitWithSessions(\DateTime $createdDate, array $pages)
    {
        $session = factory(Session::class)->create([
            'start_session' => $createdDate
        ]);
        foreach ($pages as $page) {
            factory(Visit::class)->create([
                'session_id' => $session->id,
                'page_id' => $page
            ]);
        }
    }
}


