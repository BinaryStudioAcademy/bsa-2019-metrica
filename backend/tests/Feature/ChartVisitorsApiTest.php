<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visit;
use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DateTime;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChartVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testGetTotalVisitorsByDateRange()
    {
        $website = factory(Website::class)->create();
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
        factory(Visitor::class)->create(['id' => 1]);
        factory(Visitor::class)->create(['id' => 2]);
        factory(Visitor::class)->create(['id' => 3]);
        factory(Visitor::class)->create(['id' => 4]);

        factory(Website::class)->create();
        factory(Page::class)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();

        $firstDate = Carbon::create(2019, 6, 23, 12, 12, 12)->toDateTime();
        $secondDate = Carbon::create(2019, 7, 10, 12, 12, 12)->toDateTime();
        $thirdDate = Carbon::create(2019, 7, 19, 12, 12, 12)->toDateTime();
        $fourthDate = Carbon::create(2019, 8, 1, 12, 12, 12)->toDateTime();
        $fifthDate = Carbon::create(2019, 8, 15, 12, 12, 12)->toDateTime();

        factory(Visit::class)->create([
            'visit_time' => $firstDate,
            'visitor_id' => 1
        ]);
        factory(Visit::class)->create([
            'visit_time' => $firstDate,
            'visitor_id' => 4
        ]);
        factory(Visit::class)->create([
            'visit_time' => $secondDate,
            'visitor_id' => 2
        ]);
        factory(Visit::class)->create([
            'visit_time' => $thirdDate,
            'visitor_id' => 3
        ]);
        factory(Visit::class)->create([
            'visit_time' => $fourthDate,
            'visitor_id' => 2
        ]);
        factory(Visit::class)->create([
            'visit_time' => $fifthDate,
            'visitor_id' => 1
        ]);

        $filterData = [
            'filter' => [
            'startDate' => (string)$firstDate->getTimestamp(),
                'endDate' => (string)$fifthDate->getTimestamp(),
                'period' => '86400',
                'website_id' => $website->id
            ]
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-total-visitors', $filterData)
            ->assertStatus(200)
            ->assertJson([
            "data" => [
                0 => [
                    "date" => "1561248000",
                    "value" => "2"
                ],
                1 => [
                    "date" => "1562716800",
                    "value" => "1"
                ],
                2 => [
                    "date" => "1563494400",
                    "value" => "1"
                ]
            ],
            "meta" => []
        ]);
    }

    public function testGetNewChartVisitorsByDateRange()
    {
        $website = factory(Website::class)->create();
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
        $firstDate = new DateTime('@1566070350');
        $secondDate = new DateTime('@1566156750');
        $thirdDate = new DateTime('@1566243150');
        $fourthDate = new DateTime('@1566305040');
        $fifthDate = new DateTime('@1566326640');

        factory(Visitor::class)->create([
            'created_at' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $secondDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $thirdDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fourthDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fifthDate
        ]);

        $filterData = [
            'filter' => [
                'startDate' => (string)$secondDate->getTimestamp(),
                'endDate' => (string)$fifthDate->getTimestamp(),
                'period' => 86400,
                'website_id' => $website->id
            ]
        ];
        $expectedData = [
            'data' => [
                [
                    'date' => '1566086400',
                    'value' => 1
                ],
                [
                    'date' => '1566172800',
                    'value' => 1
                ],
                [
                    'date' => '1566259200',
                    'value' => 2
                ],
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-new-visitors', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }
}
