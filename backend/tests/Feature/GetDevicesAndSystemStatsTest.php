<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class GetDevicesAndSystemStatsTest extends TestCase
{
    use RefreshDatabase;

    const DEVICES = 'api/v1/devices/stats';
    const SYSTEMS = 'api/v1/os/most-popular';

    private $user;
    private $website;
    private $from;
    private $to;

    public function setUp(): void
    {
        parent::setUp();
        $this->from = Carbon::now()->subDays(3);
        $this->to = Carbon::now();
        $this->user = factory('App\Entities\User')->create();
        $this->website = factory('App\Entities\Website')->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        $this->website->pages()->save(factory('App\Entities\Page')->make());
        factory('App\Entities\Visitor')->create();
        factory('App\Entities\GeoPosition')->create();
        factory('App\Entities\System')->create();
    }

    public function query()
    {
        return [
            'filter' => [
                'startDate' => (string)$this->from->timestamp,
                'endDate' => strval($this->to->timestamp),
                'website_id' => $this->website->id
            ]
        ];
    }

    public function testInvalidFilterParameter()
    {
        $this->actingAs($this->user)
            ->json('GET', self::DEVICES, ['filter' =>
                [
                    'startDate' => (string)$this->from->timestamp,
                    'endDate' => '0',
                    'website_id' => $this->website->id
                ],
            ])
            ->assertStatus(400)
            ->assertJsonStructure(['error' => ['message']]);
    }

    public function testCorrectDeviceResponseStructure()
    {
        factory('App\Entities\System')->create(['device' => 'desktop'])
            ->sessions()->save(factory('App\Entities\Session')->make())
            ->visit()->save(factory('App\Entities\Visit')->make());

        $this->actingAs($this->user)
            ->json('GET', self::DEVICES, $this->query())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'percent'
                    ]
                ],
                'meta' => []
            ]);
    }

    public function testCorrectSystemsResponseStructure()
    {
        factory('App\Entities\System')->create(['os' => 'Mac OS'])
            ->sessions()->save(factory('App\Entities\Session')->make())
            ->visit()->save(factory('App\Entities\Visit')->make());
        $this->actingAs($this->user)
            ->json('GET', self::SYSTEMS, $this->query())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'percent'
                    ]
                ],
                'meta' => []
            ]);
    }

    public function testDevicesResponse()
    {
        $systems = [ 'Mac OS', 'Linux', 'Linux', 'Android', 'Android'];
        foreach ($systems as $system) {
            factory('App\Entities\System')->create(['os' => $system])
                ->sessions()->save(factory('App\Entities\Session')->make())
                    ->visit()->save(factory('App\Entities\Visit')->make());
        }

        $response = $this->actingAs($this->user)
            ->json('GET', self::SYSTEMS, $this->query())
            ->assertStatus(200)
            ->assertJsonFragment(
                [ "name" => "Linux", "percent" => 40 ]
            )
            ->assertJsonFragment(
                [ "name" => "Android", "percent" => 40 ]
            )->json();
        $this->assertCount(2, $response['data']);
    }

    public function testSystemsResponse()
    {
        $deviceTypes = [ 'tablet', 'tablet', 'mobile', 'mobile', 'desktop'];
        foreach ($deviceTypes as $type) {
            factory('App\Entities\System')->create(['device' => $type])
                ->sessions()->save(factory('App\Entities\Session')->make())
                ->visit()->save(factory('App\Entities\Visit')->make());
        }

        $response = $this->actingAs($this->user)
            ->json('GET', self::DEVICES, $this->query())
            ->assertStatus(200)
            ->assertJsonFragment(
                [ "name" => "mobile", "percent" => 40 ]
            )
            ->assertJsonFragment(
                [ "name" => "tablet", "percent" => 40 ]
            )
            ->assertJsonFragment(
                [ "name" => "desktop", "percent" => 20 ]
            )->json();
        $this->assertCount(3, $response['data']);
    }

    public function testNoResultsReturned()
    {
        factory('App\Entities\Session')
            ->create(['start_session' => $this->from->subDays(1)->toDateString()])
            ->visits()->save(factory('App\Entities\Visit')->make());

        $result = $this->actingAs($this->user)
            ->json('GET', self::DEVICES, $this->query())
            ->assertStatus(200)
            ->json();
        $this->assertEmpty($result['data']);
    }
}
