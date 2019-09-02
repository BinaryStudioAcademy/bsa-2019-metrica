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
use App\Events\VisitCreated;
use DateTime;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class VisitsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;
    private $visitor;
    private $page;
    private $system;
    private $url = 'api/v1/chart-visits/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        $this->visitor = factory(Visitor::class)->create();
        $this->page = factory(Page::class)->create();
        factory(GeoPosition::class)->create();
        $this->system = factory(System::class)->create();
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
                'period' => 60000,
                'website_id' => $this->website->id
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
                        'date' => '1565700000',
                        'value' => 3
                    ],

                    [
                        'date' => '1565820000',
                        'value' => 1
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
                'period' => 60000,
                'website_id' => $this->website->id
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
                'period' => 60000,
                'website_id' => $this->website->id
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
           ->assertStatus(400)
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
                'period' => 60000,
                'website_id' => $this->website->id
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
                'period' => 0,
                'website_id' => $this->website->id
            ]
        ];

        factory(Visit::class)->create([
            'created_at' => new DateTime('@1564734209'),

        ]);

        $expectedData = [
            'error' => [
                'message' => 'Interval must more 1 s'
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', $this->url, $filterData)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }

    public function testBounceRateByTimeFrameAction()
    {
        $endpoint = 'api/v1/page-views/bounce-rate';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 07:30:00');

        factory(Page::class)->create(['id' => 11]);
        factory(Page::class)->create(['id' => 12]);
        factory(Page::class)->create(['id' => 13]);
        factory(Page::class)->create(['id' => 14]);

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'period' => "3600",
                'website_id' => $this->website->id
            ]
        ];

        $this->createVisitWithSessions(new DateTime('2019-08-20 05:30:00'), [14]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:10:00'), [12]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:20:00'), [11,13,12,11]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:30:00'), [12,14]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:30:00'), [11]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:50:00'), [14,12]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:10:00'), [11,14,12]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:30:00'), [13]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:30:00'), [14]);
        $this->createVisitWithSessions(new DateTime('2019-08-20 08:30:00'), [11]);

        $expectedData = [
            'data' => [
                [
                    'date' => (string) $startDate->getTimestamp(),
                    'value' => "0.2",
                ],
                [
                    'date' => (string) ($startDate->getTimestamp() + 3600),
                    'value' => "0.4",
                ]
            ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function createVisitWithSessions(DateTime $createdDate, array $pages)
    {
        $session = factory(Session::class)->create([
            'start_session' => $createdDate
        ]);
        foreach ($pages as $page) {
            factory(Visit::class)->create([
                'session_id' => $session->id,
                'page_id' => $page
            ]);
        }
    }

    public function testCreateVisitAction()
    {
        Event::fake();
        $faker = Factory::create();
        $language = $faker->languageCode;
        $userAgent = $faker->userAgent;
        $ip = $faker->ipv4;
        $payload = JWTFactory::customClaims([
            'sub' => env('API_ID'),
            'visitor_id' => $this->visitor->id
        ])->make();
        $token = JWTAuth::encode($payload);

        $data = [
            'page' => $this->page->url,
            'page_title' => $this->page->name,
            'language' => $language,
            'device' => $this->system->device,
            'resolution_width' => $this->system->resolution_width,
            'resolution_height' => $this->system->resolution_height
        ];

        $headers = [
            'User-Agent' => $userAgent,
            'REMOTE_ADDR' => $ip,
            'X-Visitor' => 'Bearer ' . $token
        ];

        $url = 'api/v1/visits/';

        $this->actingAs($this->user)
            ->json('POST', $url, $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseHas('visits', [
            'ip_address' => $ip
        ]);
    }

    public function testSendNotificationVisitCreated()
    {
        Event::fake();
        $faker = Factory::create();
        $language = $faker->languageCode;
        $userAgent = $faker->userAgent;
        $ip = $faker->ipv4;
        $payload = JWTFactory::customClaims([
            'sub' => env('API_ID'),
            'visitor_id' => $this->visitor->id
        ])->make();
        $token = JWTAuth::encode($payload);

        $data = [
            'page' => $this->page->url,
            'page_title' => $this->page->name,
            'language' => $language,
            'device' => $this->system->device,
            'resolution_width' => $this->system->resolution_width,
            'resolution_height' => $this->system->resolution_height
        ];

        $headers = [
            'User-Agent' => $userAgent,
            'REMOTE_ADDR' => $ip,
            'X-Visitor' => 'Bearer ' . $token
        ];

        $url = 'api/v1/visits/';

        $this->actingAs($this->user)
            ->json('POST', $url, $data, $headers)
            ->assertStatus(200);

        $visit = Visit::latest()->first();

        Event::assertDispatched(VisitCreated::class, function ($e) use ($visit) {
            return $e->visit->id === $visit->id;
        });

        $this->assertDatabaseHas('visits', [
            'ip_address' => $ip
        ]);
    }
}
