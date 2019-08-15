<?php

namespace Tests\Feature;

use App\Entities\Browser;
use App\Entities\Demographic;
use App\Entities\Device;
use App\Entities\GeoPosition;
use App\Entities\Os;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Visitor;
use App\Entities\Website;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitsApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testPageViewsFilter()
    {
        $firstDate = new DateTime('@1565846640');

        $filterData = [
            'filter' => [
                'startDate' => $firstDate->getTimestamp(),
                'endDate' => $firstDate->getTimestamp(),
                'period' => 60000
            ]
        ];

        factory(Website::class)->create();
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(Device::class)->create();
        factory(Browser::class)->create();
        factory(Os::class)->create();
        factory(GeoPosition::class)->create();
        factory(Demographic::class)->create();
        factory(System::class)->create();
        factory(Session::class)->create();

        factory(Visit::class)->create([
            'created_at' => $firstDate,

        ]);

        $expectedData = [
            'data' => [
                 'date' => '1565846640',
                 'visits' => 1

            ],
            'meta' => [],
        ];

       $request =  $this->actingAs($this->user)
            ->call('GET', 'api/v1/chart-visits/', $filterData)
            ->assertStatus(200)
           ->assertJson($expectedData)
        ;

    }
}
