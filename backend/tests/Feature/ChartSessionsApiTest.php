<?php

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Collection;

class ChartSessionsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $url = 'api/v1/chart-sessions/';

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

    public function testChartSessionsFilter()
    {
        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 06:05:00'),
            'end_session' => new DateTime('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 06:15:00'),
            'end_session' => new DateTime('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 06:20:00'),
            'end_session' => new DateTime('2019-08-19 08:30:00')
        ]);

        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 06:25:00'),
            'end_session' => new DateTime('2019-08-19 06:50:00')
        ]);

        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 06:30:00'),
            'end_session' => new DateTime('2019-08-19 06:55:00')
        ]);

        factory(Session::class)->create([
            'start_session' => new DateTime('2019-08-19 07:30:00'),
            'end_session' => new DateTime('2019-08-19 08:30:00')
        ]);

        $startDate = new DateTime('2019-08-19 06:01:00');
        $endDate = new DateTime('2019-08-19 08:01:00');

        $filterData = [
            'filter' => [
                'startDate' => (string) $startDate->getTimestamp(),
                'endDate' => (string) $endDate->getTimestamp(),
                'period' => 3600
            ]
        ];

        $date2 = new DateTime('2019-08-19 07:01:00'); //1566198060
        $date3 = new DateTime('2019-08-19 08:01:00'); //1566201660

        $expectedData = [
            'data' =>
                [
                    [
                        'date' => (string) $date2->getTimestamp(),
                        'sessions' => 5
                    ],
                    [
                        'date' => (string) $date3->getTimestamp(),
                        'sessions' => 4
                    ],
                ],
            'meta' => [],
        ];

        $response = $this->actingAs($this->user)->json('GET', $this->url, $filterData);

        $response->assertStatus(200)
            ->assertJson($expectedData);
    }
}
