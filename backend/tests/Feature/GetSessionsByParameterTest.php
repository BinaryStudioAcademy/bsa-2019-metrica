<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class GetSessionsByParameterTest extends TestCase
{
    use RefreshDatabase;
    
    const ENDPOINT = 'api/v1/sessions/param';

    private $user;
    private $from;
    private $to;
    private $query;

    public function setUp(): void
    {
        parent::setUp();
        $this->from = Carbon::now()->subDays(3);
        $this->to = Carbon::now();
        $this->user = factory('App\Entities\User')->create();
        $this->user->website()->save(factory('App\Entities\Website')->make())
            ->pages()->save(factory('App\Entities\Page')->make());
        factory('App\Entities\Visitor')->create();
        factory('App\Entities\GeoPosition')->create();
        factory('App\Entities\System')->create();
    }

    public function testInvalidFilterParameter()
    {
        $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('wrong_parameter'))
            ->assertStatus(400)
            ->assertJsonStructure(['error' => ['message']]);
    }

    public function testCorrectResponseStructure()
    {
        factory('App\Entities\Session')->create(['language' => 'fr'])
            ->visits()->save(factory('App\Entities\Visit')->make());

        $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'parameter',
                        'parameter_value',
                        'total',
                        'percentage'
                    ]
                ],
                'meta' => []
            ]);
    }

    public function testFilteringByLanguage()
    {
        factory('App\Entities\Session', 2)->create(['language' => 'ua'])
            ->each(function($session) {
                $session->visits()->save(factory('App\Entities\Visit')->make());
            });
        factory('App\Entities\Session', 8)->create(['language' => 'fr'])
        ->each(function($session) {
            $session->visits()->save(factory('App\Entities\Visit')->make());
        });
        $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery())
            ->assertStatus(200)
            ->assertJsonFragment(
                    [
                        "parameter" => "language",
                        "parameter_value" => "ua",
                        "total" => "2",
                        "percentage" => 20,
                    ],
                    [
                        "parameter" => "language",
                        "parameter_value" => "fr",
                        "total" => "8",
                        "percentage" => 80,
                    ]
            );
    }

    /** @test */
    public function testNoSessionsReturned()
    {
        factory('App\Entities\Session')
            ->create(['start_session' => $this->from->subDays(1)->toDateString()])
            ->visits()->save(factory('App\Entities\Visit')->make());

        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery())
            ->assertStatus(200)
            ->json();
        $this->assertEmpty($result['data']);
    }

    public function testFilteringBySystemParams()
    {
        $params = [
            ['resolution_width' => '1024', 'resolution_height' => '768', 'os' => 'Windows NT 4.0', 'browser' => 'Mozilla/5.0'],
            ['resolution_width' => '960', 'resolution_height' => '720', 'os' => 'X11; Linux i686', 'browser' => 'Mozilla/5.0'],
            ['resolution_width' => '800', 'resolution_height' => '600', 'os' => 'X11; Linux i686', 'browser' => 'Mozilla/5.0'],
            ['resolution_width' => '800', 'resolution_height' => '600',  'os' => 'X11; Linux i686', 'browser' => 'Mozilla/5.0'],
        ];
        foreach ($params as $param) {
            factory('App\Entities\System', 2)->create($param)->each(function($system) {
                $system->sessions()->save(factory('App\Entities\Session')->make())
                ->visit()->save(factory('App\Entities\Visit')->make());
            });
        }
        // GROUPING BY SCREEN RESOLUTION SHOULD RETURN 3 DATA ITEMS
        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('screen_resolution'))
            ->assertStatus(200)
            ->assertSee('960x720')
            ->assertJsonFragment([
                "parameter" => "screen_resolution",
                "parameter_value" => "1024x768",
                "percentage" => 25,
                "total" => "2"
            ])
            ->json();
        $this->assertEquals(3, sizeof($result['data']));
        // GROUPING BY BROWSER SHOULD RETURN 1 DATA ITEM
        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('browser'))
            ->assertStatus(200)
            ->json();
        $this->assertEquals(1, sizeof($result['data']));
        // GROUPING BY OS SHOULD RETURN 2 DATA ITEMS
        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('operating_system'))
            ->assertStatus(200)
            ->json();
        $this->assertEquals(2, sizeof($result['data']));
    
    }

    public function testFilteringByGeoPosition()
    {
        $cities = ['Kwekwe', 'Hwange', 'Bulawayo'];

        foreach ($cities as $city) {
            $geoPosition = factory('App\Entities\GeoPosition')->create([
                'country' => 'Zimbabwe', 'city' => $city
            ]);
            factory('App\Entities\System')->create()
                ->sessions()->save(factory('App\Entities\Session')->make())
                ->visit()->save(factory('App\Entities\Visit')->make([
                    'geo_position_id' => $geoPosition->id
                ]));
        }

        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('city'))
            ->assertStatus(200)
            ->json();
        $this->assertEquals(3, sizeof($result['data']));

        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $this->getQuery('country'))
            ->assertStatus(200)
            ->json();
        $this->assertEquals(1, sizeof($result['data']));
    }

    private function getQuery($parameter = 'language')
    {
        return [
            'filter' => [
                'startDate' => strval($this->from->timestamp),
                'endDate' => strval($this->to->timestamp),
                'parameter' => $parameter
            ],
        ];
    }
}
