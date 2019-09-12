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

    private $websiteOwner;
    private $firstTeamMember;
    private $secondTeamMember;
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
                            "user_id" => $this->firstTeamMember->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "visitors",
                                "page-views",
                                "geo-location",
                                "behaviour",
                                "screencast",
                                "page-timings",
                                "error-reports",
                            ]
                        ],
                        [
                            "user_id" => $this->secondTeamMember->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "visitors",
                                "page-views",
                                "geo-location",
                                "behaviour",
                                "screencast",
                                "page-timings",
                                "error-reports"
                            ]
                        ],
                    ],
                    "meta" => []
                ];

        $this->actingAs($this->websiteOwner)
            ->call('GET', self::ENDPOINT.$this->websiteOwner->id, $requestData)
            ->assertJson($expected)
            ->assertStatus(200);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->firstTeamMember->id,
            'website_id' => $this->website->id,
            'role' => 'member',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
        ]);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->secondTeamMember->id,
            'website_id' => $this->website->id,
            'role' => 'member',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
        ]);
    }

    public function test_update_permitted_menu_items_for_team_member()
    {
        $requestData = [
            'filter' => [
                'user_ids' => [
                    $this->firstTeamMember->id,
                    $this->secondTeamMember->id
                ],
                'permitted_menu' => [
                    'geo-location, behaviour',
                    'visitors, page-views'
                ],
                'website_id' => $this->website->id
            ]
        ];

        $expected = [
                    "data" => [
                        [
                            "user_id" => $this->firstTeamMember->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "geo-location",
                                "behaviour"
                            ]
                        ],
                        [
                            "user_id" => $this->secondTeamMember->id,
                            "website_id" => $this->website->id,
                            "permitted_menu" => [
                                "visitors",
                                "page-views"
                            ]
                        ],
                    ],
                    "meta" => []
                ];

        $this->actingAs($this->websiteOwner)
            ->call('PUT', self::ENDPOINT, $requestData)
            ->assertJson($expected)
            ->assertStatus(200);
    }


    private function setUsers(): void
    {
        $this->websiteOwner = factory(User::class)->create();
        $this->firstTeamMember = factory(User::class)->create();
        $this->secondTeamMember = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {
        $this->website = factory(Website::class)->create();
        $this->websiteOwner->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        $this->firstTeamMember->websites()->attach($this->website->id, [
            'role' => 'member'
        ]);
        $this->secondTeamMember->websites()->attach($this->website->id, [
            'role' => 'member'
        ]);
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(System::class)->create();
        factory(GeoPosition::class)->create();
        factory(Session::class)->create();
    }
}
