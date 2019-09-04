<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Entities\Website;
use App\Entities\Visitor;
use App\Entities\Session;
use App\Entities\Page;
use App\Entities\System;
use App\Entities\GeoPosition;
use Illuminate\Support\Collection;

class PermittedMenuItemsTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $secondUser;
    private $website;
    const ENDPOINT = '/api/v1/teams/menu-access/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUsers();
        $this->seedDataBase();
    }

    public function test_get_permitted_menu_items_for_team_member()
    {
        $requestData = ['website_id' => $this->website->id];

        $expected = [
                    "data" => [
                        [
                            "user_id" => $this->secondUser->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "visitors",
                                "page-views",
                                "geo-location",
                                "behaviour",
                                "screencast"
                            ]
                        ],
                        [
                            "user_id" => $this->user->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "visitors",
                                "page-views",
                                "geo-location",
                                "behaviour",
                                "screencast"
                            ]
                        ],
                    ],
                    "meta" => []
                ];

        $this->actingAs($this->user)
            ->call('GET', self::ENDPOINT.$this->user->id, $requestData)
            ->assertJson($expected)
            ->assertStatus(200);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->user->id,
            'website_id' => $this->website->id,
            'role' => 'member',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
        ]);
    }

    private function setUsers(): void
    {
        $this->user = factory(User::class)->create();
        $this->secondUser = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {
        $this->website = factory(Website::class)->create();
        $this->secondUser->websites()->attach($this->website->id, [
            'role' => 'member'
        ]);
        $this->user->websites()->attach($this->website->id, [
            'role' => 'member'
        ]);
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(System::class)->create();
        factory(GeoPosition::class)->create();
        factory(Session::class)->create();
    }
}
