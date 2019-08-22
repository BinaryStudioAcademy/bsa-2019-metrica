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
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Website::class, 1)->create(
            ['user_id' => $this->user->id]
        );
        factory(Page::class, 1)->create();
        factory(System::class, 1)->create();
        factory(GeoPosition::class, 1)->create();
    }

    public function testNewVisitorsAction()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->call('GET', 'api/v1/visitors/new');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAllVisitorsAction()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->json('GET', 'api/v1/visitors');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNewVisitorsCountAction()
    {
        $firstDate = new DateTime('@1565734002');
        $secondDate = new DateTime('@1565734102');
        $thirdDate = new DateTime('@1565734202');
        $fourthDate = new DateTime('@1565734302');
        factory(Visitor::class)->create([
            'created_at' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $secondDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $thirdDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fourthDate
        ]);
        $filterData = [
            'filter' => [
                'startDate' => (string)$secondDate->getTimestamp(),
                'endDate' => (string)$thirdDate->getTimestamp()
            ]
        ];

        $expectedData = [
            'data' => [
                'value' => 2,
            ],
            'meta' => [],

        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/visitors/new/count', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function testBounceRateByTimeFrameAction()
    {
        $endpoint = 'api/v1/visitors/bounce-rate';

        $startDate = new DateTime('2019-08-20 06:00:00');
        $endDate = new DateTime('2019-08-20 08:00:00');
        $anHour = 60 * 60;

        $filterData = [
            'filter' => [
                'startDate' => $startDate->getTimestamp(),
                'endDate' => $endDate->getTimestamp(),
                'timeFrame' => $anHour,
            ]
        ];

        factory(Visitor::class)->create([
            'created_at' => new DateTime('2019-08-20 05:30:00')
        ]);

        $this->createVisitorWithVisits(new DateTime('2019-08-20 06:30:00'), 1);
        $this->createVisitorWithVisits(new DateTime('2019-08-20 06:30:00'), 2);
        $this->createVisitorWithVisits(new DateTime('2019-08-20 07:30:00'), 1);
        $this->createVisitorWithVisits(new DateTime('2019-08-20 07:30:00'), 2);
        $this->createVisitorWithVisits(new DateTime('2019-08-20 07:30:00'), 2);
        $this->createVisitorWithVisits(new DateTime('2019-08-20 07:30:00'), 2);
        factory(Visitor::class)->create([
            'created_at' => new DateTime('2019-08-20 08:30:00')
        ]);

        $expectedData = [
            'data' => [
                [
                    'date' => (string)$startDate->getTimestamp(),
                    'value' => 0.5,
                ],
                [
                    'date' => (string)($startDate->getTimestamp() + $anHour),
                    'value' => 0.25,
                ]
            ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->json('GET', $endpoint, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function createVisitorWithVisits(DateTime $createdDate, int $countVisits)
    {
        $visitor = factory(Visitor::class)->create([
            'created_at' => $createdDate
        ]);
        $session = factory(Session::class)->create([
            'start_session' => $visitor->created_at,
            'visitor_id' => $visitor->id
        ]);
        factory(Visit::class, $countVisits)->create([
            'session_id' => $session->id,
            'visitor_id' => $visitor->id
        ]);

        return $visitor;
    }

    public function testNewVisitorsCountWithInvalidDataAction()
    {
        $secondDate = new DateTime('@1565734102');
        $thirdDate = new DateTime('@1565734202');
        $filterData = [
            'filter' => [
                'startDate' => (string)$thirdDate->getTimestamp(),
                'endDate' => (string)$secondDate->getTimestamp()
            ]
        ];

        $expectedData = [
            'error' => [
                'message' => 'The filter.end date must be a date after ' . $thirdDate->getTimestamp() . '.',
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/visitors/new/count', $filterData)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }

    public function testGetBounceRateAction()
    {
        foreach ($this->visitorsData() as $visitorsDatum) {
            $this->createVisitor($visitorsDatum);
        }

        $query = [
            'filter' => [
                'start_date' => (string)Carbon::yesterday()->subDay()->timestamp,
                'end_date' => (string)Carbon::today()->timestamp
            ]
        ];
        $endpoint = 'api/v1/visitors/bounce-rate/total';

        $expected = [
            'data' => [
                'value' => round(1 / 6 * 100, 2)
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', $endpoint, $query)
            ->assertStatus(200)
            ->assertJson($expected);
    }

    public function createVisitor(array $params): void
    {
        [
            'sessions_count' => $sessionCount,
            'visits_count' => $visitsCount,
            'start_session' => $startSession,
            'updated_at' => $updatedAt
        ] = $params;

        $visitor = factory(Visitor::class)->create();

        if ($sessionCount === 0) {
            return;
        }

        $sessions = factory(Session::class, $sessionCount)
            ->create([
                'start_session' => $startSession,
                'updated_at' => $updatedAt,
                'visitor_id' => $visitor->id
            ])
            ->each(function (Session $session) use ($visitsCount, $visitor) {
                $session->visits()->saveMany(
                    factory(Visit::class, $visitsCount)->make([
                        'visitor_id' => $visitor->id
                    ])
                );
            });

        $visitor->sessions()->saveMany($sessions);
    }

    public function visitorsData(): array
    {
        return [
            [
                'sessions_count' => 1,
                'visits_count' => 1,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::now()
            ],
            [
                'sessions_count' => 1,
                'visits_count' => 2,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::now()
            ],
            [
                'sessions_count' => 1,
                'visits_count' => 1,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday()
            ],
            [
                'sessions_count' => 1,
                'visits_count' => 2,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday()
            ],
            [
                'sessions_count' => 2,
                'visits_count' => 1,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::now()
            ],
            [
                'sessions_count' => 2,
                'visits_count' => 1,
                'start_session' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday()
            ],
            [
                'sessions_count' => 1,
                'visits_count' => 1,
                'start_session' => Carbon::create(2018),
                'updated_at' => Carbon::now()
            ],
            [
                'sessions_count' => 1,
                'visits_count' => 1,
                'start_session' => Carbon::create(2018),
                'updated_at' => Carbon::create(2019)
            ],
        ];
    }
}
