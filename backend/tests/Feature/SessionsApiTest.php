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

class SessionsApiTest extends TestCase
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
        factory(Visit::class)->create();
    }

    public function testGetAvgSessionsTimeByParameter()
    {
        $parameters = [
            'language',
            'country',
            'city',
            'operating_system',
            'browser',
            'screen_resolution'
        ];
        $query = [
            'filter' => [
                'start_date' => (string) Carbon::yesterday()->subDay()->timestamp,
                'end_date' => (string) Carbon::today()->timestamp,
            ]
        ];
        $endpoint = 'api/v1/table-sessions/avg-session-time';

        $expected = [
            'data' => [
                '*' => [
                    'parameter',
                    'parameter_value',
                    'total',
                    'percentage'
                ]
            ],
            'meta' => []
        ];
        foreach ($parameters as $parameter) {
            $query['filter']['parameter'] = $parameter;

            $this->actingAs($this->user)
                ->json('GET', $endpoint, $query)
                ->assertStatus(200)
                ->assertJsonCount(1, 'data')
                ->assertJsonStructure($expected);
        }
    }
}
