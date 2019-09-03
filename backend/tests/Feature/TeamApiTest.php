<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamApiTest extends TestCase
{
    use RefreshDatabase;

    private const EXPECTED_DATA = [
        "data" => [
            [
                "id" => 2,
                "name" => "member_1",
                "email" => "email_2"
            ],
            [
                "id" => 3,
                "name" => "member_2",
                "email" => "email_3"
            ],
            [
                "id" => 4,
                "name" => "member_3",
                "email" => "email_4"
            ]
        ],
        "meta" => []
    ];

    private $owner;
    private $website;
    private $members = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->website = factory(Website::class)->create(['id' => 1]);
        $this->owner = factory(User::class)->create([
            'id' => 1,
            'name' => 'owner',
            'email' => 'email_1'
        ]);
    }

    public function testGetTeamAsOwner()
    {
        $this->attachRole();

        $filterData = [
            'website_id' => $this->website->id,
        ];

        $this->actingAs($this->owner)
            ->call('GET', 'api/v1/team', $filterData)
            ->assertOk()
            ->assertJson(self::EXPECTED_DATA);
    }

    public function testGetTeamAsMember()
    {
        $this->attachRole();

        $filterData = [
            'website_id' => $this->website->id,
        ];

        $this->actingAs($this->members[0])
            ->call('GET', 'api/v1/team', $filterData)
            ->assertOk()
            ->assertJson(self::EXPECTED_DATA);
    }

    public function attachRole()
    {
        array_push($this->members, factory(User::class)->create([
            'id' => 2,
            'name' => 'member_1',
            'email' => 'email_2'
        ]));
        array_push($this->members, factory(User::class)->create([
            'id' => 3,
            'name' => 'member_2',
            'email' => 'email_3'
        ]));
        array_push($this->members, factory(User::class)->create([
            'id' => 4,
            'name' => 'member_3',
            'email' => 'email_4'
        ]));
        $this->owner->websites()->attach($this->website->id, ['role' => 'owner']);

        foreach ($this->members as $member) {
            $member->websites()->attach($this->website->id, ['role' => 'member']);
        }
    }
}