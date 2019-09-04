<?php


namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Collection;

class TableAverageTimingByParamTest extends TestCase
{
    use RefreshDatabase;

    const PAGE_LOAD = 'api/v1/page-timing/table/page-loading';
    const DNS_LOOKUP = 'api/v1/page-timing/table/domain-lookup';
    const SERVER_RESPONSE = 'api/v1/page-timing/table/server-response';

    private $user;
    private $from;
    private $to;
    private $website;

    protected function setUp(): void
    {
        parent::setUp();
        $this->from = \Illuminate\Support\Carbon::now()->subDays(3);
        $this->to = Carbon::now();
        $this->user = factory('App\Entities\User')->create();
        $this->website = $this->user->website()
            ->save(factory('App\Entities\Website')->make());
        factory('App\Entities\Visitor')->create();
    }

    public function testInvalidFilterParameter()
    {
        $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, ['filter' =>
                [
                    'startDate' => (string)$this->from->timestamp,
                    'endDate' => '0',
                    'param' => 'browser'
                ],
            ])
            ->assertStatus(400)
            ->assertJsonStructure(['error' => ['message']]);
    }

    public function testGroupByBrowserResponse()
    {
        factory('App\Entities\GeoPosition')->create();
        $this->website->pages()->save(factory('App\Entities\Page')->make());
        foreach ($this->browsers() as $browser) {
            foreach ($this->params() as $param) {
                factory('App\Entities\System')->create(['browser' => $browser])
                    ->sessions()->save(factory('App\Entities\Session')->make())
                    ->visits()->save(factory('App\Entities\Visit')->make($param));
            }
        }
        $response = $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, $this->query('browser'))
            ->assertStatus(200)
            ->assertJsonFragment(["parameter_value" => 'Vivaldi', "average_time" => 350])
            ->json();
        $this->assertCount(5, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::DNS_LOOKUP, $this->query('browser'))
            ->assertStatus(200)
            ->assertJsonFragment(["parameter_value" => 'Vivaldi', "average_time" => 75])
            ->json();
        $this->assertCount(5, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::SERVER_RESPONSE, $this->query('browser'))
            ->assertStatus(200)
            ->assertJsonFragment(["parameter_value" => 'Vivaldi', "average_time" => 250])
            ->json();
        $this->assertCount(5, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));
    }

    public function testGroupByPageResponse()
    {
        factory('App\Entities\GeoPosition')->create();
        factory('App\Entities\System')->create();
        $params = $this->params();
        $pages = new Collection();
        foreach ($this->urls() as $url) {
            $pages->push($this->website->pages()
                ->save(factory('App\Entities\Page')->make(['url' => $url])));
        }
        factory('App\Entities\Session')->create();
        $pages->each(function($page) use ($params) {
            foreach ($params as $param) {
                $page->visits()->save(factory('App\Entities\Visit')
                    ->make($param));
            }
        });

        $response = $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, $this->query('page'))
            ->assertStatus(200)
            ->assertJsonFragment([
                "parameter_value" => "badplace.com/page1",
                "average_time" => 350])
            ->json();
        $this->assertCount(3, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::DNS_LOOKUP, $this->query('page'))
            ->assertStatus(200)
            ->assertJsonFragment(["average_time" => 75])
            ->json();
        $this->assertCount(3, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::SERVER_RESPONSE, $this->query('page'))
            ->assertStatus(200)
            ->assertJsonFragment(["average_time" => 250])
            ->json();
        $this->assertCount(3, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));
    }

    public function testGroupByCountryResponse()
    {
        $this->website->pages()->save(factory('App\Entities\Page')->make());
        factory('App\Entities\System')->create();
        factory('App\Entities\Session')->create();
        foreach ($this->countries() as $country) {
            foreach ($this->params() as $param) {
                factory('App\Entities\GeoPosition')->create(['country' => $country])
                    ->visits()->save(factory('App\Entities\Visit')->make($param));
            }
        }

        $response = $this->actingAs($this->user)
            ->json('GET', self::PAGE_LOAD, $this->query('country'))
            ->assertStatus(200)
            ->assertJsonFragment([
                "parameter_value" => "China",
                "average_time" => 350
            ])
            ->json();
        $this->assertCount(4, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::DNS_LOOKUP, $this->query('country'))
            ->assertStatus(200)
            ->assertJsonFragment(["average_time" => 75])
            ->json();
        $this->assertCount(4, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));

        $response = $this->actingAs($this->user)
            ->json('GET', self::SERVER_RESPONSE, $this->query('country'))
            ->assertStatus(200)
            ->assertJsonFragment(["average_time" => 250])
            ->json();
        $this->assertCount(4, $response['data']);
        $this->assertTrue($this->is_sorted($response['data']));
    }

    public function params()
    {
        return [
            [
                'page_load_time' => 300,
                'domain_lookup_time' => 65,
                'server_response_time' => 200
            ],
            [
                'page_load_time' => 350,
                'domain_lookup_time' => 75,
                'server_response_time' => 250
            ],
            [
                'page_load_time' => 400,
                'domain_lookup_time' => 85,
                'server_response_time' => 300
            ]
        ];
    }

    public function urls()
    {
        return [
            'badplace.com/page1',
            'badplace.com/page2',
            'badplace.com/page3'
        ];
    }

    public function countries()
    {
        return ['China', 'North Korea', 'Cuba', 'Venezuela'];
    }

    public function browsers()
    {
        return ['Chrome', 'Firefox', 'Vivaldi', 'Opera', 'Safari'];
    }

    public function query(string $parameter)
    {
        return [
            'filter' => [
                'startDate' => strval($this->from->timestamp),
                'endDate' => strval($this->to->timestamp),
                'parameter' => $parameter
            ]
        ];
    }

    public function is_sorted(array $data)
    {
        $original = $data;
        usort($data, function ($item1, $item2) {
            return $item2['average_time'] <=> $item1['average_time'];
        });
        return $data == $original;
    }
}
