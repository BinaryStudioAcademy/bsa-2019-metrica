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
use App\Listeners\SendVisitsNotification;
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
    private $visitor;
    private $page;
    private $system;
    private $url = 'api/v1/chart-visits/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Website::class)->create();
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
                        'value' => 3
                    ],

                    [
                        'date' => '1565846640',
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

    public function testBounceRateByTimeFrameAction()
    {
        $endpoint = 'api/v1/page-views/bounce-rate';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 07:30:00');

        factory(Page::class)->create(['id' => 1]);
        factory(Page::class)->create(['id' => 2]);
        factory(Page::class)->create(['id' => 3]);
        factory(Page::class)->create(['id' => 4]);
        factory(Page::class)->create(['id' => 5]);

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
                'period' => "3600",
            ]
        ];

        $this->createVisitWithSessions(new DateTime('2019-08-20 05:30:00'), 2, 4);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:00:00'), 1, 2);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:20:00'), 1, 5);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:30:00'), 1, 2);
        $this->createVisitWithSessions(new DateTime('2019-08-20 06:30:00'), 2, 1);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:00:00'), 1, 4);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:20:00'), 1, 1);
        $this->createVisitWithSessions(new DateTime('2019-08-20 07:30:00'), 1, 3);
        $this->createVisitWithSessions(new DateTime('2019-08-20 08:00:00'), 3, 5);

        $expectedData = [
            'data' => [
                [
                    'date' => (string) $startDate->getTimestamp(),
                    'value' => "0.5",
                ],
                [
                    'date' => (string) ($startDate->getTimestamp() + 3600),
                    'value' => "1",
                ]
            ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function createVisitWithSessions(DateTime $createdDate, int $countVisits, int $pageId)
    {
        $session = factory(Session::class)->create([
            'start_session' => $createdDate
        ]);
        $visit = factory(Visit::class, $countVisits)->create([
            'session_id' => $session->id,
            'page_id' => $pageId
        ]);

        return $visit;
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

    public function testReturnDataHandleListener()
    {
        Event::fake();

        $visit = factory(Visit::class)->create();

        $event = \Mockery::mock(VisitCreated::class);
        $event->visit = $visit;

        $listener = app()->make(SendVisitsNotification::class);

        $returnListener = $listener->handle($event);
        $this->assertContains($visit->page->url, $returnListener["page"]);
        $this->assertEquals($visit->visitor_id, $returnListener["visitor"]);
        $this->assertEquals($visit->created_at, $returnListener["time_notification"]);
    }
}
