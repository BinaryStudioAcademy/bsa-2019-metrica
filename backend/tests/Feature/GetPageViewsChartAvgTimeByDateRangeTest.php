<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestDataFactory;
use Illuminate\Support\Carbon;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Website;
use App\Entities\Session;
use App\Entities\GeoPosition;
use App\Entities\System;
use App\Entities\Page;
use App\Entities\Visitor;

class GetPageViewsChartAvgTimeByDateRangeTest extends TestCase
{
    use RefreshDatabase;

    const DATE_FROM = '2019-08-20 00:00:00';
    const DATE_TO = '2019-08-24 23:59:59';
    const ENDPOINT = '/api/v1/chart-page-views/avg-time/';

    private $user;
    private $website;
    private $fromTimeStamp;
    private $toTimeStamp;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUser();
        $this->seedDataBase();
        $this->fromTimeStamp = (new Carbon(self::DATE_FROM))->timestamp;
        $this->toTimeStamp = (new Carbon(self::DATE_TO))->timestamp;
    }

    public function test_get_new_visitors_by_param()
    {
        $requestData = [
            'startDate' => $this->fromTimeStamp,
            'endDate' => $this->toTimeStamp,
            'period' => 21600
        ];

        $queryString = '?filter[startDate]='.$requestData['startDate'].
                         '&filter[endDate]='.$requestData['endDate'].
                         '&filter[period]='.$requestData['period'].
                         '&filter[website_id]='.$this->website->id;

        $expected = [
            'data' => [
                [
                    "date" => "1566345600",
                    "value" => "2700"
                ],
                [
                    "date" => "1566388800",
                    "value" => "3600"
                ],
                [
                    "date" => "1566410400",
                    "value" => "0"
                ],
                [
                    "date" => "1566432000",
                    "value" => "4800"
                ],
                [
                    "date" => "1566453600",
                    "value" => "4800"
                ]
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->getJson(self::ENDPOINT.$queryString)
            ->assertOk()
            ->assertJson($expected);
    }

    private function setUser(): User
    {
        return $this->user = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        factory(Visitor::class, 5)->create();
        factory(Page::class, 3)->create();
        factory(System::class)->create();
        factory(GeoPosition::class)->create();


        $firstSession = factory(Session::class)->create([
                            'start_session' => '2019-08-21 00:00:00',
                            'end_session' =>  '2019-08-22 00:00:00'
                        ]);
        for ($i = 0, $hours = 0; $i < 4; $i++, $hours += 1) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-21'))->addHours($hours)
                                                          ->toDateTimeString(),
                'session_id' => $firstSession->id
            ]);
        }

        $secondSession = factory(Session::class)->create([
                            'start_session' => '2019-08-21 15:00:00',
                            'end_session' =>  '2019-08-21 21:00:00'
                        ]);
        for ($i = 0, $hours = 0; $i < 3; $i++, $hours += 2) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-21 15:00:00'))->addHours($hours)
                                                          ->toDateTimeString(),
                'session_id' => $secondSession->id
            ]);
        }

        $thirdSession = factory(Session::class)->create([
                            'start_session' => '2019-08-22 00:00:00',
                            'end_session' =>  '2019-08-23 00:00:00'
                        ]);

        for ($i = 0, $hours = 0; $i < 6; $i++, $hours += 2) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-22'))->addHours($hours)
                                                          ->toDateTimeString(),
                'session_id' => $thirdSession->id
            ]);
        }

        $outOfDateRangeSession = factory(Session::class)->create([
                                    'start_session' => '2019-08-30 00:00:00',
                                    'end_session' =>  '2019-08-31 00:00:00'
                                ]);
        for ($i = 0, $hours = 0; $i < 5; $i++, $hours += 1) {
            factory(Visit::class)->create([
                'visit_time' => (new Carbon('2019-08-30'))->addHours($hours)
                                                          ->toDateTimeString(),
                'session_id' => $outOfDateRangeSession->id
            ]);
        }
    }
}
