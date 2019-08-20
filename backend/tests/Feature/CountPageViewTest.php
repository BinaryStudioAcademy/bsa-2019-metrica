<?php

namespace Tests\Feature;

use App\Entities\Visit;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Entities\Website;
use App\Entities\Visitor;
use App\Entities\Session;
use App\Entities\Page;
use App\Entities\System;
use App\Entities\GeoPosition;

class CountPageViewTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Website::class)->create();
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();
    }

    public function testCountPageViews()
    {
        $dateFilter = [
            'startDate' => Carbon::parse( '2019-08-18 00:00:00')->timestamp,
            'endDate' => Carbon::parse( '2019-08-20 00:00:00')->timestamp,
        ];
        $this->createVisits();
        $queryString = '?filter[startDate]='.$dateFilter['startDate'].
            '&filter[endDate]='.$dateFilter['endDate'];

        $expected = [
            'data' => [
                'count' => 4
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->getJson('/api/v1/button-page-views/count/'.$queryString)
            ->assertJson($expected);
    }

    private function createVisits(): void
    {
        foreach ($this->getVisitsTime() as $visitTime) {
            factory(Visit::class)->create([
                'visit_time' => $visitTime,
            ]);
        }
    }

    private function getVisitsTime(): array
    {
        return [
            '2019-08-18 10:00:00',
            '2019-08-18 20:00:00',
            '2019-08-19 10:00:00',
            '2019-08-19 20:00:00',
            '2019-08-21 10:00:00',
        ];
    }
}


