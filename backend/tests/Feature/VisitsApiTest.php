<?php

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Visitor;
use App\Entities\Website;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $url = 'api/v1/chart-visits/';

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

    public function testPageViewsFilter()
    {
        $firstDate = new DateTime('@1565846640');
        $secondDate = new DateTime('@1565734102');

        $filterData = [
            'filter' => [
                'startDate' => (string) $secondDate->getTimestamp(),
                'endDate' => (string) $firstDate->getTimestamp(),
                'period' => 60000
            ]
        ];

        factory(Visit::class)->create([
            'created_at' => $firstDate,

        ]);

        factory(Visit::class)->create([
            'created_at' => $secondDate,

        ]);

        factory(Visit::class)->create([
            'created_at' => $secondDate,

        ]);

        factory(Visit::class)->create([
            'created_at' => $secondDate,

        ]);

        $expectedData = [
            'data' =>
                [
                    [
                        'date' => '1565734080',
                        'visits' => 3
                    ],

                    [
                        'date' => '1565846640',
                        'visits' => 1
                    ],

                ],
            'meta' => [],
        ];


        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function testPageViewsNotVisitsInPeriod()
    {
        $firstDate = new DateTime('@1565846640');
        $secondDate = new DateTime('@1565734102');

        $filterData = [
            'filter' => [
                'startDate' => (string) $secondDate->getTimestamp(),
                'endDate' => (string) $firstDate->getTimestamp(),
                'period' => 60000
            ]
        ];

        factory(Visit::class)->create([
            'created_at' => new DateTime('@1564734209'),

        ]);

        $expectedData = [
            'data' => [
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertJson($expectedData);
    }

    public function testPageViewsVisitsDoNotBelongWebsite()
    {
        $firstDate = new DateTime('@1565846640');
        $secondDate = new DateTime('@1565734102');

        $filterData = [
            'filter' => [
                'startDate' => (string) $secondDate->getTimestamp(),
                'endDate' => (string) $firstDate->getTimestamp(),
                'period' => 60000
            ]
        ];

        $user = factory(User::class)->create();

        $expectedData = [
            'error' => [
                'message' => 'Website not found.',
            ],
        ];

        $this->actingAs($user)
            ->call('GET', $this->url, $filterData)
           ->assertStatus(404)
            ->assertJson($expectedData);
    }

    public function testPageViewsNotVisitsDateRange()
    {
        $startDate = new DateTime('@1565734102');
        $endDate = new DateTime('@1565734202');
        $filterData = [
            'filter' => [
                'startDate' => (string) $endDate->getTimestamp(),
                'endDate' => (string) $startDate->getTimestamp(),
                'period' => 60000
            ]
        ];

        $expectedData = [
            'error' => [
                'message' => 'The filter.end date must be a date after '. $endDate->getTimestamp() . '.',
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }

    public function testPageViewsFailedInterval()
    {
        $firstDate = new DateTime('@1565846640');
        $secondDate = new DateTime('@1565734102');

        $filterData = [
            'filter' => [
                'startDate' => (string) $secondDate->getTimestamp(),
                'endDate' => (string) $firstDate->getTimestamp(),
                'period' => 499
            ]
        ];

        factory(Visit::class)->create([
            'created_at' => new DateTime('@1564734209'),

        ]);

        $expectedData = [
            'error' => [
                'message' => 'Interval must more 500 ms'
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }
}
