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
        factory(Website::class)->create();
        factory(Visitor::class)->create(['id' => 1]);
        factory(Visitor::class)->create(['id' => 2]);
        factory(Visitor::class)->create(['id' => 3]);

        factory(Website::class)->create();
        factory(Page::class)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();

        $firstDate = new DateTime('@1566070350');
        $secondDate = new DateTime('@1566156750');
        $thirdDate = new DateTime('@1566243150');
        $fourthDate = new DateTime('@1566305040');
        $fifthDate = new DateTime('@1566326640');
  
        factory(Visit::class)->create([
            'visit_time' => $firstDate,
            'visitor_id' => 1
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
            'startDate' => (string)$thirdDate->getTimestamp(),
                'endDate' => (string)$fifthDate->getTimestamp(),
                'period' => '86400'
            ]
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-total-visitors', $filterData, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'period',
                    'count'
                ],
            ],
            'meta' => []
        ]);
    }

    public function testGetNewChartVisitorsByDateRange()
    {
        factory(Website::class)->create();
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
                'period' => 86400
            ]
        ];
        $expectedData = [
            'data' => [
                [
                    'period' => '1566086400',
                    'count' => 1
                ],
                [
                    'period' => '1566172800',
                    'count' => 1
                ],
                [
                    'period' => '1566259200',
                    'count' => 2
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