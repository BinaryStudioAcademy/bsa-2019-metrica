<?php


namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ButtonsAverageTimingTest extends TestCase
{
    use RefreshDatabase;

    const PAGE_LOAD = 'api/v1/page-timing/button/page-loading';
    const DNS_LOOKUP = 'api/v1/page-timing/button/domain-lookup';
    const SERVER_RESPONSE = 'api/v1/page-timing/button/server-response';

    private $user;
    private $from;
    private $to;
    private $page;

    protected function setUp(): void
    {
        parent::setUp();
        $this->from = \Illuminate\Support\Carbon::now()->subDays(3);
        $this->to = Carbon::now();
        $this->user = factory('App\Entities\User')->create();
        $this->user->website()->save(factory('App\Entities\Website')->make());
        $this->page = $this->user->website
            ->pages()->save(factory('App\Entities\Page')->make());
        factory('App\Entities\Visitor')->create();
        factory('App\Entities\GeoPosition')->create();
        factory('App\Entities\System')->create();
        factory('App\Entities\Session')->create();

        //visits withing the time frame
        foreach ($this->params() as $param) {
            $this->page->visits()->save(factory('App\Entities\Visit')->make($param));
        };

        //visit for another website
        factory('App\Entities\Website')->create()
            ->pages()->save(factory('App\Entities\Page')->make())
            ->visits()->save(factory('App\Entities\Visit')->make([
            'page_load_time' => 100,
            'domain_lookup_time' => 50,
            'server_response_time' => 150,
        ]));

        //earlier visit
        $this->page->visits()->save(factory('App\Entities\Visit')->make([
            'page_load_time' => 100,
            'domain_lookup_time' => 50,
            'server_response_time' => 150,
            'visit_time' => Carbon::now()->subDays(10)
        ]));
    }

    public function query()
    {
        return [
            'filter' => [
                'startDate' => strval($this->from->timestamp),
                'endDate' => strval($this->to->timestamp)
            ]
        ];
    }

    public function params()
    {
        return [
            ['page_load_time' => 300, 'domain_lookup_time' => 65, 'server_response_time' => 200],
            ['page_load_time' => 350, 'domain_lookup_time' => 75, 'server_response_time' => 250],
            ['page_load_time' => 400, 'domain_lookup_time' => 85, 'server_response_time' => 300]
        ];
    }

    public function testInvalidFilterParameter()
    {
        $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, ['filter' =>
                [
                    'startDate' => (string)$this->from->timestamp,
                    'endDate' => '0'
                ],
            ])
            ->assertStatus(400)
            ->assertJsonStructure(['error' => ['message']]);
    }

    public function testResponse()
    {
        $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, $this->query())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    "value" => "350"
                ]
            );

        $this->actingAs($this->user)
            ->json('GET', self::DNS_LOOKUP, $this->query())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    "value" => "75"
                ]
            );

        $this->actingAs($this->user)
            ->json('GET', self::SERVER_RESPONSE, $this->query())
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    "value" => "250"
                ]
            );
    }
}
