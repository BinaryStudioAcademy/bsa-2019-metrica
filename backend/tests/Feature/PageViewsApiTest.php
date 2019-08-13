<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\Page;
use App\Entities\User;
use App\Entities\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

final class PageViewsApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_URL = '/api/v1/pages/';
    private $user;
    private $website;
    private $page;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create();
        $this->page = factory(Page::class)->create();
    }

    public function testGetPageViewsCollection()
    {
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)->get(self::API_URL . $this->page->id . '/views', $headers)->assertOk();
    }
}