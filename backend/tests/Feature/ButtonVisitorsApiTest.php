<?php


namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ButtonVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testButtonCountVisitors()
    {
        $website = factory(Website::class)->create();
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
        $firstDate = Carbon::parse('2019-08-11 22:00:45', 'UTC');
        $secondDate = Carbon::parse('2019-08-18 19:32:30', 'UTC');
        $secondDateLastActivity = Carbon::parse('2019-08-22 22:00:45', 'UTC');
        $thirdDate = Carbon::parse('2019-08-20 22:00:45', 'UTC');
        $fourthDate = Carbon::parse('2019-08-23 22:00:45', 'UTC');
        $fifthDate = Carbon::parse('2019-08-24 22:00:45', 'UTC');
        $sixDate = Carbon::parse('2019-07-24 22:00:45', 'UTC');
        $sixDateLastActivity = Carbon::parse('2019-08-21 22:00:45', 'UTC');

        factory(Visitor::class)->create([
            'created_at' => $firstDate,
            'last_activity' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $secondDate,
            'last_activity' => $secondDateLastActivity
        ]);
        factory(Visitor::class)->create([
            'created_at' => $thirdDate,
            'last_activity' => $thirdDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fourthDate,
            'last_activity' => $fourthDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fifthDate,
            'last_activity' => $fifthDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $sixDate,
            'last_activity' => $sixDateLastActivity
        ]);
        $filterData = [
            'filter' => [
                'startDate' => (string)$thirdDate->getTimestamp(),
                'endDate' => (string)$fourthDate->getTimestamp(),
                'website_id' => $website->id
            ]
        ];
        $expectedData = [
            'data' => [
                'value' => '4'
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/button-visitors', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }
}
