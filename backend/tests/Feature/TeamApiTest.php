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

    private $owner;
    private $website;
    private $members;

    protected function setUp(): void
    {
        parent::setUp();
        $this->website = factory(Website::class)->create();
        $this->owner = factory(User::class)->create();
        $this->members = factory(User::class, 3)->create();
    }

    public function testGetTeamAsOwner()
    {
        $this->attachRole();

        $filterData = [
            'website_id' => $this->website->id,
        ];

        $expectedData = [

        ];

        $this->actingAs($this->owner)
            ->call('GET', 'api/v1/team', $filterData)
            ->assertOk()
            ->assertJson($expectedData);
    }

    public function testGetTeamAsMember()
    {
        $this->attachRole();

        $filterData = [
            'website_id' => $this->website->id,
        ];

        $expectedData = [

        ];

        $this->actingAs($this->members[0])
            ->call('GET', 'api/v1/team', $filterData)
            ->assertOk()
            ->assertJson($expectedData);


    }

    public function attachRole()
    {
        $this->owner->websites()->attach($this->website->id, ['role' => 'owner']);

        foreach ($this->members as $member)
        {
            $member->websites()->attach($this->website->id, ['role' => 'member']);
        }
    }
}