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
    }

    public function testGetSessions()
    {
        $this->createSessions();
        $filterData = [
            'filter' => [
                'startDate' => (string)Carbon::parse('2019-07-30 00:00:00', 'UTC')->getTimestamp(),
                'endDate' => (string)Carbon::parse('2019-08-30 00:00:00', ' UTC')->getTimestamp(),
                'period' => 604800
            ]
        ];

        $expectedData = [
            'data' =>
                [
                    [
                        'date' => (string)Carbon::parse('2019-07-30 00:00:00', 'UTC')->getTimestamp(),
                        'value' => '3'
                    ],
                    [
                        'date' => (string)Carbon::parse('2019-08-06 00:00:00', 'UTC')->getTimestamp(),
                        'value' => '1'
                    ],
                    [
                        'date' => (string)Carbon::parse('2019-08-13 00:00:00', 'UTC')->getTimestamp(),
                        'value' => '2'
                    ],
                    [
                        'date' => (string)Carbon::parse('2019-08-20 00:00:00', 'UTC')->getTimestamp(),
                        'value' => '3'
                    ],
                    [
                        'date' => (string)Carbon::parse('2019-08-27 00:00:00', 'UTC')->getTimestamp(),
                        'value' => '2'
                    ]
                ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function createSessions():void
    {
        factory(Session::class)->create([
            'start_session' => '2019-07-19 06:05:00',
            'end_session' => '2019-07-20 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-07-30 06:05:00',
            'end_session' => '2019-07-30 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-02 06:05:00',
            'end_session' => '2019-08-02 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-04 06:05:00',
            'end_session' => '2019-08-04 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-08 06:05:00',
            'end_session' => '2019-08-08 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-14 06:05:00',
            'end_session' => '2019-08-14 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-15 06:05:00',
            'end_session' => '2019-08-15 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-21 06:05:00',
            'end_session' => '2019-08-21 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-23 06:05:00',
            'end_session' => '2019-08-23 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-25 06:05:00',
            'end_session' => '2019-08-25 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-28 06:05:00',
            'end_session' => '2019-08-28 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-29 06:05:00',
            'end_session' => '2019-08-29 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-08-31 06:05:00',
            'end_session' => '2019-08-31 08:30:00'
        ]);

        factory(Session::class)->create([
            'start_session' => '2019-09-31 06:05:00',
            'end_session' => '2019-09-31 08:30:00'
        ]);

    }
}
