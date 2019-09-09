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
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityVisitorTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;
    private $firstDate;
    private $secondDate;
    private $thirdDate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create([
            'id' => 1
        ]);
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        $firstDate = Carbon::now('UTC')->subMinutes(15);
        $secondDate = Carbon::now('UTC')->subMinutes(1);
        $thirdDate = Carbon::now('UTC')->subMinutes(2);
        $this->firstDate = $firstDate;
        $this->secondDate = $secondDate;
        $this->thirdDate = $thirdDate;
        $this->seedDataBase();
    }

    public function testGetActivityUsersAction()
    {
        $filterData = [
            'website_id' => $this->website->id,
        ];

        $expectedData = [
            "data" => [
                [
                    'url' => "http://page_1.test",
                    'visitor' => 1,
                    'date' => $this->thirdDate->format('Y-m-d H:i:s')
                ],
            ],
            "meta" => [],

        ];

        $this->actingAs($this->user)
            ->call('GET', 'api/v1/visitors/activity-visitors', $filterData)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function seedDataBase()
    {
        factory(Website::class)->create([
            'id' => 1,
            'user_id'=>1
        ]);
        factory(Visitor::class)->create(
            [
                'id' => 1,
                'last_activity' => $this->thirdDate,
            ]
        );

        factory(Visitor::class)->create(
            [
                'id' => 2,
                'last_activity' => $this->firstDate,
            ]
        );

        factory(Page::class)->create([
            'id' => 1,
            'url' => 'http://page_1.test'
        ]);
        factory(Page::class)->create([
            'id' => 2,
            'url' => 'http://page_2.test'
        ]);
        factory(System::class)->create();
        factory(GeoPosition::class)->create();
        factory(Session::class)->create();


        factory(Visit::class)->create(
            [
                'page_id' => 1,
                'visitor_id' => 1,
                'created_at' => $this->firstDate
            ]
        );

        factory(Visit::class)->create(
            [
                'page_id' => 1,
                'visitor_id' => 1,
                'created_at' => $this->thirdDate
            ]
        );

        factory(Visit::class)->create(
            [
                'page_id' => 2,
                'visitor_id' => 1,
                'created_at' => $this->thirdDate
            ]
        );

        factory(Visit::class)->create(
            [
                'page_id' => 2,
                'visitor_id' => 2,
                'created_at' => $this->firstDate
            ]
        );
    }
}
