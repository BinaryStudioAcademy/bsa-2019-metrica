<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\User;
use App\Entities\Website;
use App\Http\Controllers\Api\WebsiteController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiWebsiteTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user;
    private $websiteController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->websiteController = $this->app->make(WebsiteController::class);
    }


    public function test_add()
    {
        $expectedData = [
            "data" => [
                'name' => $this->faker->name,
                'domain' => $this->faker->domainName,
                'single_page' => true,
                'user_id' => $this->user->id,
                'tracking_number' => '00000001',
            ],
            "meta" => [],

        ];
        $websiteData = [
            'name' => $expectedData['data']['name'],
            'domain' => $expectedData['data']['domain'],
            'single_page' => true,
        ];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)
            ->post('/api/v1/websites', $websiteData, $headers)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function test_add_two_websites()
    {
        $expectedData = [
            "data" => [
                'name' => $this->faker->name,
                'domain' => $this->faker->domainName,
                'single_page' => true,
                'user_id' => $this->user->id,
                'tracking_number' => '00000002',
            ],
            "meta" => [],

        ];
        $firstWebsiteData = [
            'name' => $this->faker->name,
            'domain' => $this->faker->domainName,
            'single_page' => true,
        ];
        $secondWebsiteData = [
            'name' => $expectedData['data']['name'],
            'domain' => $expectedData['data']['domain'],
            'single_page' => true,
        ];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)
            ->post('/api/v1/websites', $firstWebsiteData, $headers)
            ->assertStatus(200);

        $this->actingAs($this->user)
            ->post('/api/v1/websites', $secondWebsiteData, $headers)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function test_success_edit()
    {
        $website = factory(Website::class)->create();
        $expectedData = [
            "data" => [
                'name' => 'New name',
                'domain' => $website->domain,
                'single_page' => $website->single_page,
                'user_id' => $website->user_id,
                'tracking_number' => $website->tracking_number,
            ],
            "meta" => [],

        ];
        $websiteData = [
            'name' => $expectedData['data']['name'],
            'single_page' => $expectedData['data']['single_page'],
        ];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)
            ->put('/api/v1/websites/'.$website->id, $websiteData, $headers)
            ->assertStatus(200)
            ->assertJson($expectedData);
    }

    public function test_without_required_field_edit()
    {
        $expectedData = [
            'error' => [
                'message' => 'The name field is required.'
            ]
        ];
        $website = factory(Website::class)->create();
        $websiteData = [];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)
            ->put('/api/v1/websites/'.$website->id, $websiteData, $headers)
            ->assertStatus(400)
            ->assertJson($expectedData);
    }

    public function test_edit_not_exist()
    {
        $expectedData = [
            'error' => [
                'message' => 'Website not found.'
            ]
        ];
        $websiteData = [
            'name' => 'name',
        ];
        $failId = 100;
        $token = JWTAuth::fromUser($this->user);
        $headers = ['Authorization' => "Bearer $token"];

        $this->actingAs($this->user)
            ->put('/api/v1/websites/'.$failId, $websiteData, $headers)
            ->assertStatus(404)
            ->assertJson($expectedData);
    }
}
