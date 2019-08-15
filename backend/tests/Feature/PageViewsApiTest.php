<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

final class PageViewsApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_URL = '/api/v1/visits';
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testGetPageViewsCollection()
    {
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)->get(self::API_URL, $headers)->assertOk();
    }
}