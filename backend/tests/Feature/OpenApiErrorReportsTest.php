<?php

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visitor;
use App\Entities\Website;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class openApiErrorReportsTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $visitor;
    private $page;
    private $system;
    private $session;
    private $website;
    private $url = 'api/v1/error-reports/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->website = factory(Website::class)->create();
        $this->visitor = factory(Visitor::class)->create();
        $this->page = factory(Page::class)->create([
            'url' => 'https://google.com'
        ]);
        factory(GeoPosition::class)->create();
        $this->system = factory(System::class)->create();
        $this->session = factory(Session::class)->create();
    }

    public function testAddErrorWithVisitor()
    {
        Event::fake();
        $faker = Factory::create();
        $message = $faker->name;
        $stack_trace = $faker->text;
        $payload = JWTFactory::customClaims([
            'sub' => env('API_ID'),
            'visitor_id' => $this->visitor->id
        ])->make();
        $token = JWTAuth::encode($payload);

        $data = [
            'page' => $this->page->url,
            'page_title' => $this->page->name,
            'message' => $message,
            'stack_trace' => $stack_trace,
        ];

        $headers = [
            'X-Visitor' => 'Bearer ' . $token,
            'X-Website' => $this->website->tracking_number
        ];

        $this->actingAs($this->user)
            ->json('POST', $this->url, $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseHas('errors', [
            'stack_trace' => $stack_trace,
            'visitor_id' => $this->visitor->id,
        ]);
    }

    public function testAddErrorWithoutVisitor()
    {
        Event::fake();
        $faker = Factory::create();
        $message = $faker->name;
        $stack_trace = $faker->text;

        $data = [
            'page' => 'https://google23.com',
            'page_title' => $this->page->name,
            'message' => $message,
            'stack_trace' => $stack_trace,
        ];

        $headers = [
            'X-Website' => $this->website->tracking_number
        ];

        $this->actingAs($this->user)
            ->json('POST', $this->url, $data, $headers)
            ->assertStatus(200);

        $this->assertDatabaseHas('errors', [
            'stack_trace' => $stack_trace,
            'visitor_id' => null,
        ]);
    }
}
