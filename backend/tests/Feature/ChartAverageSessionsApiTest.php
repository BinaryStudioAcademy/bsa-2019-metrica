<?php

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChartAverageSessionsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;
    private $url = 'api/v1/chart-average-sessions/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();
    }

    public function testChartSessionsFilter()
    {
        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 06:05:00'),
            'end_session' => Carbon::create('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 06:15:00'),
            'end_session' => Carbon::create('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 06:20:00'),
            'end_session' => Carbon::create('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 06:25:00'),
            'end_session' => Carbon::create('2019-08-19 06:50:00')
        ]);

        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 06:30:00'),
            'end_session' => Carbon::create('2019-08-19 06:55:00')
        ]);

        factory(Session::class)->create([
            'start_session' => Carbon::create('2019-08-19 07:30:00'),
            'end_session' => Carbon::create('2019-08-19 08:30:00')
        ]);

        $startDate = Carbon::create('2019-08-19 06:01:00');
        $endDate = Carbon::create('2019-08-19 08:01:00');

        $filterData = [
            'filter' => [
                'startDate' => (string) $startDate->getTimestamp(),
                'endDate' => (string) $endDate->getTimestamp(),
                'period' => 3600,
                'website_id' => $this->website->id
            ]
        ];

        $date2 = Carbon::create('2019-08-19 07:01:00');
        $date3 = Carbon::create('2019-08-19 08:01:00');

        $expectedData = [
            'data' =>
                [
                    [
                        'date' => (string)$date2->getTimestamp(),
                        'value' => '2316',
                    ],
                    [
                        'date' => (string)$date3->getTimestamp(),
                        'value' => '3165',
                    ],
                ],
            'meta' => [],
        ];

        $response = $this->actingAs($this->user)->json('GET', $this->url, $filterData);

        $response->assertStatus(200)
            ->assertJson($expectedData);
    }
}
