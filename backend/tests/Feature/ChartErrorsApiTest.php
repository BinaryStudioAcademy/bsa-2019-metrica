<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\Error;
use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visit;
use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChartErrorsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        factory(Website::class)->create([
            'id' => 1
        ]);
        factory(Website::class)->create([
            'id' => 2
        ]);
        factory(Website::class)->create([
            'id' => 3
        ]);
        factory(Website::class)->create([
            'id' => 4
        ]);
        factory(Page::class)->create([
            'id' => 1,
            'website_id' => 1
        ]);
        factory(Page::class)->create([
            'id' => 2,
            'website_id' => 2
        ]);
        factory(Visitor::class)->create();
        factory(Page::class)->create([
            'id' => 3,
            'website_id' => 3
        ]);
        factory(Page::class)->create([
            'id' => 4,
            'website_id' => 4
        ]);
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();
        factory(Visit::class)->create();
    }

    public function testGetCountErrorByDateRange()
    {
        $firstDate = Carbon::create(2019, 6, 23, 12, 12, 12)->toDateTime();
        $secondDate = Carbon::create(2019, 7, 10, 12, 12, 12)->toDateTime();
        $thirdDate = Carbon::create(2019, 7, 19, 12, 12, 12)->toDateTime();
        $fourthDate = Carbon::create(2019, 8, 1, 12, 12, 12)->toDateTime();
        $fifthDate = Carbon::create(2019, 8, 15, 12, 12, 12)->toDateTime();

        factory(Error::class)->create([
            'created_at' => $firstDate,
            'page_id'=>1
        ]);
        factory(Error::class)->create([
            'created_at' => $secondDate,
            'page_id'=>2
        ]);
        factory(Error::class)->create([
            'created_at' => $secondDate,
            'page_id'=>1
        ]);
        factory(Error::class)->create([
            'created_at' => $thirdDate,
            'page_id'=>1
        ]);
        factory(Error::class)->create([
            'created_at' => $fourthDate,
            'page_id'=>1
        ]);


        $filterData = [
            'filter' => [
                'startDate' => (string)$firstDate->getTimestamp(),
                'endDate' => (string)$fifthDate->getTimestamp(),
                'period' => '86400'
            ]
        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/errors/count', $filterData)
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "date" => "1561248000",
                        "value" => "1"
                    ],
                    [
                        "date" => "1562716800",
                        "value" => "1"
                    ],
                    [
                        "date" => "1563494400",
                        "value" => "1"
                    ],
                    [
                        "date" => "1564617600",
                        "value" => "1"
                    ]
                ],
                "meta" => []
            ]);
    }
}
