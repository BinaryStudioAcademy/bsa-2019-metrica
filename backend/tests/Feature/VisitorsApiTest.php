<?php

namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
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
        $response = $this->actingAs($user)->call('GET', 'api/v1/visitors');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNewVisitorsCountAction()
    {
        $firstDate = new DateTime('@1565734002');
        $secondDate = new DateTime('@1565734102');
        $thirdDate = new DateTime('@1565734202');
        $fourthDate = new DateTime('@1565734302');
        factory(Website::class)->create();
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
                'startDate' => $secondDate->getTimestamp(),
                'endDate' => $thirdDate->getTimestamp()
            ]
        ];

        $expectedData = [
            'data' => [
                'count' => 2,
            ],
            'meta' => [],

        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/visitors/new/count', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function testNewVisitorsCountWithInvalidDataAction()
    {
        $secondDate = new DateTime('@1565734102');
        $thirdDate = new DateTime('@1565734202');
        $filterData = [
            'filter' => [
                'startDate' => $thirdDate->getTimestamp(),
                'endDate' => $secondDate->getTimestamp()
            ]
        ];

        $expectedData = [
            'error' => [
                'message' => 'Start date can\'t be greater then end date',
            ],
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/visitors/new/count', $filterData)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }
}
