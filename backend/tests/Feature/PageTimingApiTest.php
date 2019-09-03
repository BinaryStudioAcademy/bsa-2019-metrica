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

class PageTimingApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Website::class)->create([
            'domain' => 'google.com'
        ]);
        factory(Page::class)->create([
            'url' => 'https://google.com'
        ]);
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
    }


    public function testAvgPageLoadingByPeriod()
    {
        $endpoint = 'api/v1/page-timing/chart/page-loading';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 08:00:00');
        $anHour = 60 * 60;

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'period' => (string)$anHour,
            ]
        ];

        $expectedData = [
            'data' => [
                [
                    'date' => (string)$startDate->getTimestamp(),
                    'value' => 325,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour),
                    'value' => 350,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour*2),
                    'value' => 0,
                ]
            ],
            'meta' => [],
        ];

        $this->seedPageTimingsData();

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function testAvgDomainLookupByPeriod()
    {
        $endpoint = 'api/v1/page-timing/chart/domain-lookup';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 08:00:00');
        $anHour = 60 * 60;

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'period' => (string)$anHour,
            ]
        ];

        $expectedData = [
            'data' => [
                [
                    'date' => (string)$startDate->getTimestamp(),
                    'value' => 70,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour),
                    'value' => 77,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour*2),
                    'value' => 0,
                ]
            ],
            'meta' => [],
        ];

        $this->seedPageTimingsData();

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function testAvgServerResponseByPeriod()
    {
        $endpoint = 'api/v1/page-timing/chart/server-response';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 08:00:00');
        $anHour = 60 * 60;

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'period' => (string)$anHour,
            ]
        ];

        $expectedData = [
            'data' => [
                [
                    'date' => (string)$startDate->getTimestamp(),
                    'value' => 300,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour),
                    'value' => 300,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour*2),
                    'value' => 0,
                ]
            ],
            'meta' => [],
        ];

        $this->seedPageTimingsData();

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function seedPageTimingsData()
    {
        factory(Visitor::class)->create([
            'created_at' => new DateTime('2019-08-20 05:30:00')
        ]);

        $this->createVisit(new DateTime('2019-08-20 06:30:00'), 300, 75, 250);
        $this->createVisit(new DateTime('2019-08-20 06:30:00'), 350, 65, 350);
        $this->createVisit(new DateTime('2019-08-20 07:30:00'), 350, 75, 250);
        $this->createVisit(new DateTime('2019-08-20 07:30:00'), 400, 85, 350);
        $this->createVisit(new DateTime('2019-08-20 07:30:00'), 300, 95, 150);
        $this->createVisit(new DateTime('2019-08-20 07:30:00'), 350, 55, 450);
    }


    private function createVisit(
        DateTime $createdDate,
        int $loadingTime,
        int $domainLookupTime,
        int $serverResponseTime
    ) {
        $visitor = factory(Visitor::class)->create([
            'created_at' => $createdDate
        ]);
        $session = factory(Session::class)->create([
            'start_session' => $createdDate,
            'visitor_id' => $visitor->id
        ]);
        factory(Visit::class)->create([
            'session_id' => $session->id,
            'visitor_id' => $visitor->id,
            'page_load_time' => $loadingTime,
            'domain_lookup_time' => $domainLookupTime,
            'server_response_time' => $serverResponseTime,
            'visit_time' => $createdDate,
        ]);

        return $visitor;
    }
}
