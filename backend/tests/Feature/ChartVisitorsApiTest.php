<?php


namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DateTime;

class ChartVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testGetNewChartVisitorsByDateRange()
    {
        factory(Website::class)->create();
        $firstDate = new DateTime('@1566070350');
        $secondDate = new DateTime('@1566156750');
        $thirdDate = new DateTime('@1566243150');
        $fourthDate = new DateTime('@1566305040');
        $fifthDate = new DateTime('@1566326640');

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
        factory(Visitor::class)->create([
            'created_at' => $fifthDate
        ]);

        $filterData = [
            'filter' => [
                'startDate' => $secondDate->getTimestamp(),
                'endDate' => $fifthDate->getTimestamp(),
                'period' => 86400
            ]
        ];

        $expectedData = [
            'data' => [
                'new_visitors' => [
                    [
                        'period' => '1566086400',
                        'count' => 1
                    ],
                    [
                        'period' => '1566172800',
                        'count' => 1
                    ],
                    [
                        'period' => '1566259200',
                        'count' => 2
                    ],
                ],
            ],
            'meta' => []
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-new-visitors', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }
}
