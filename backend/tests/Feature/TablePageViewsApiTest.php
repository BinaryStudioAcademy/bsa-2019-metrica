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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TablePageViewsApiTest extends TestCase
{
    use RefreshDatabase;

    private const URL = 'api/v1/table-page-views';

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Website::class)->create();
        factory(Visitor::class, 3)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
    }

    public function testGetTablePageViewsItems()
    {
        factory(Page::class)->create([
            'id' => 1,
            'url' => 'url_1',
            'name' => 'name_1',
        ]);
        factory(Page::class)->create([
            'id' => 2,
            'url' => 'url_2',
            'name' => 'name_2',
        ]);
        factory(Page::class)->create([
            'id' => 3,
            'url' => 'url_3',
            'name' => 'name_3',
        ]);
        factory(Page::class)->create([
            'id' => 4,
            'url' => 'url_3',
            'name' => 'name_3',
        ]);

        $startDate = new \DateTime('2019-08-20 06:00:00');
        $endDate = new \DateTime('2019-08-20 07:30:00');

        $this->createVisitWithSessions(new \DateTime('2019-08-20 05:30:00'), 2, 1);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:10:00'), 1, 2);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:20:00'), 3, 2);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 06:30:00'), 2, 1);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 07:00:00'), 1, 2);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 07:20:00'), 1, 3);
        $this->createVisitWithSessions(new \DateTime('2019-08-20 08:00:00'), 3, 4);

        $filterData = [
            'filter' => [
                'startDate' => (string)$startDate->getTimestamp(),
                'endDate' => (string)$endDate->getTimestamp(),
            ]
        ];

        $expectedData = [
            "data" => [
                0 => [
                    "page_url" => "url_1",
                    "page_title" => "name_1",
                    "count_page_views" => 2,
                    "bounce_rate" => 0,
                    "exit_rate" => 1
                ],
                1 => [
                    "page_url" => "url_2",
                    "page_title" => "name_2",
                    "count_page_views" => 5,
                    "bounce_rate" => 0.4,
                    "exit_rate" => 3
                ],
                2 => [
                    "page_url" => "url_3",
                    "page_title" => "name_3",
                    "count_page_views" => 1,
                    "bounce_rate" => 1,
                    "exit_rate" => 1
                ],
            ],
            'meta' => [],
        ];

        $this->actingAs($this->user)
            ->json('GET', self::URL, $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    private function createVisitWithSessions(\DateTime $createdDate, int $countVisits, int $pageId)
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
}
