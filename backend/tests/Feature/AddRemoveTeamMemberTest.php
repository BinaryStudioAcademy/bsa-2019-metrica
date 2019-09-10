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

class AddRemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;
    const ENDPOINT = '/api/v1/teams/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUser();
        $this->seedDataBase();
    }

    public function test_add_team_member()
    {
        $requestData = [
            'filter' => [
                'website_id' => $this->website->id,
                'email' => 'test@example.com'
            ]
        ];

        $this->actingAs($this->user)
            ->post(self::ENDPOINT, $requestData)
            ->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => $requestData['filter']['email']
        ]);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->user->id + 1,
            'website_id' => $this->website->id,
            'role' => 'member'
        ]);
    }

    public function test_remove_team_member()
    {
//        $requestData = ['website_id' => $this->website->id];

        $memberId = $this->user->id + 2;

        $member = factory(User::class)->create([
            'id' => $memberId,
            'email' => 'remove@member.com'
        ]);

        $this->website->users()->attach($member, [
            'role' => 'member'
        ]);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $memberId,
            'website_id' => $this->website->id,
            'role' => 'member'
        ]);

        $this->actingAs($this->user)
            ->delete(self::ENDPOINT.'member/'.$memberId)
            ->assertStatus(204);

        $this->assertDatabaseMissing('user_website', [
            'user_id' => $memberId,
            'website_id' => $this->website->id,
            'role' => 'member'
        ]);
    }

    private function setUser(): User
    {
        return $this->user = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {
        $this->website = factory(Website::class)->create();
        $this->user->websites()->attach($this->website->id, [
            'role' => 'owner'
        ]);
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(System::class)->create();
        factory(GeoPosition::class)->create();
        factory(Session::class)->create();
    }
}
