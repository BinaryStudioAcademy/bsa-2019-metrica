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
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeoLocationApiTest extends TestCase
{
    use RefreshDatabase;

    private const GEOLOCATION_RESPONSE_STRUCTURE = [
        'data' => [
            '*' => [
                'country',
                'all_visitors_count',
                'new_visitors_count',
                'sessions_count',
                'bounce_rate',
                'avg_session_time'
            ]
        ],
        'meta' => []
    ];

    private const URL = 'api/v1/geo-location-items';
    private const DATE_FROM = '2019-08-20 00:00:00';
    private const DATE_TO = '2019-08-24 23:59:59';

    private $user;
    private $website;
    private $fromTimeStamp;
    private $toTimeStamp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->seedDataBase();
        $this->fromTimeStamp = (new Carbon(self::DATE_FROM))->timestamp;
        $this->toTimeStamp = (new Carbon(self::DATE_TO))->timestamp;
    }

    public function testGeoLocation()
    {
        $data = [
            'filter' => [
                'startDate' => (string) $this->fromTimeStamp,
                'endDate' => (string) $this->toTimeStamp,
                'website_id' => $this->website->id
            ]
        ];

        $this->actingAs($this->user)
            ->json('GET', self::URL, $data)
            ->assertStatus(200)
            ->assertJsonStructure(self::GEOLOCATION_RESPONSE_STRUCTURE);
    }

    private function seedDataBase(): void
    {
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        factory(Page::class, 3)->create(['website_id' => $this->website->id]);
        foreach ($this->fakeData()['visitors_created'] as $created_at) {
            factory(Visitor::class)->create([
                'website_id' => $this->website->id,
                'created_at' => $created_at
            ]);
        }

        foreach ($this->fakeData()['geo_positions'] as $geo_position) {
            $geo_positions[] = factory(GeoPosition::class)->create(
                [
                    'country' => $geo_position['country'],
                    'city' => $geo_position['city']
                ]
            );
        }

        factory(System::class, 3)->create();

        foreach ($this->fakeData()['sessions_start'] as $session_start) {
            $sessions[] = factory(Session::class)->create([
                'start_session' => $session_start,
                'end_session' => (new Carbon($session_start))->addHours(4)->toDateTimeString(),
            ]);
        }

        foreach ($geo_positions as $geo_position) {
            foreach ($sessions as $session) {
                factory(Visit::class)->create(
                    [
                        'geo_position_id' => $geo_position->id,
                        'session_id' => $session->id,
                        'visit_time' => (new Carbon($session->session_start))->addHour()->toDateTimeString(),
                    ]
                );
            }
        }

        foreach ($geo_positions as $geo_position) {
            $bounce_visitor = factory(Visitor::class)->create([
                'created_at' => '2019-08-21 00:00:00'
            ]);
            $bounce_session = factory(Session::class)->create([
                'start_session' => '2019-08-21 00:00:00',
                'end_session' => '2019-08-21 00:01:00',
                'visitor_id' => $bounce_visitor->id
            ]);
            factory(Visit::class)->create([
                'geo_position_id' => $geo_position->id,
                'visit_time' => '2019-08-21 00:00:00',
                'visitor_id' => $bounce_visitor->id,
                'session_id' => $bounce_session->id
            ]);
        }
    }

    private function fakeData(): array
    {
        return [
            'visitors_created' => [
                '2019-08-21 00:00:00',
                '2019-08-22 00:00:00',
                '2019-08-25 00:00:00',
                '2019-08-26 00:00:00',
            ],
            'sessions_start' => [
                '2019-08-21 00:00:00',
                '2019-08-22 00:00:00',
                '2019-08-25 00:00:00',
                '2019-08-26 00:00:00',
            ],

            'geo_positions' => [
                [
                    'country' => 'Ukraine',
                    'city' => 'Kiev'
                ],
                [
                    'country' => 'Germany',
                    'city' => 'Berlin'
                ],
                [
                    'country' => 'USA',
                    'city' => 'Boston'
                ],
            ],
        ];
    }
}
