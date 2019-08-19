<?php


namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
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
        factory(Website::class)->create();
        $firstDate = new DateTime('@1565560845');
        $secondDate = new DateTime('@1566156750');
        $secondDateLastActivity = new DateTime('@1566511245');
        $thirdDate = new DateTime('@1566338445');
        $fourthDate = new DateTime('@1566597645');
        $fifthDate = new DateTime('@1566684045');
        $sixDate = new DateTime('@1564005645');
        $sixDateLastActivity = new DateTime('@1566424845');

        factory(Visitor::class)->create([
            'created_at' => $firstDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $secondDate,
            'last_activity' => $secondDateLastActivity
        ]);
        factory(Visitor::class)->create([
            'created_at' => $thirdDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fourthDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $fifthDate
        ]);
        factory(Visitor::class)->create([
            'created_at' => $sixDate,
            'last_activity' => $sixDateLastActivity
        ]);

        $filterData = [
            'filter' => [
                'startDate' => (string)$thirdDate->getTimestamp(),
                'endDate' => (string)$fourthDate->getTimestamp(),
            ]
        ];
        $expectedData = [
            'data' => [
                    'value'=> '4'
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/button-visitors/count', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }
}
