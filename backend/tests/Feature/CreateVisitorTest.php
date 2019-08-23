<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Entities\Website;


class CreateVisitorTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;

    const VALID_TRACKING_NUMBER = '00000111';
    const INVALID_TRACKING_NUMBER = '00000222';
    const ENDPOINT = '/api/v1/visitors';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create([
            'tracking_number' => 111
        ]);
    }

    public function test_create_visitor_no_header()
    {
        $this->actingAs($this->user)
            ->postJson(self::ENDPOINT)
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'message' => 'x-website header is required'
                ]
            ]);
    }

    public function test_create_visitor_wrong_header()
    {
        $this->actingAs($this->user)
            ->postJson(self::ENDPOINT, [], [
                'x-website' => self::INVALID_TRACKING_NUMBER
            ])
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'message' => 'wrong x-website value'
                ]
            ]);
    }

    public function test_create_visitor_valid_header()
    {
        $this->actingAs($this->user)
            ->postJson(self::ENDPOINT, [], [
                'x-website' => self::VALID_TRACKING_NUMBER
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'token'
                ],
                'meta' => []
            ]);
    }
}


