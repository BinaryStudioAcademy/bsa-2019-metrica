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
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
        $expectedData = [
            "data" => [
                'name' => 'New name',
                'domain' => $website->domain,
                'single_page' => $website->single_page,
                'tracking_number' => $website->tracking_number,
            ],
            "meta" => [],

        ];
        $websiteData = [
            'name' => $expectedData['data']['name'],
            'single_page' => $expectedData['data']['single_page'],
        ];

        $this->actingAs($this->user)
            ->put('/api/v1/websites/'.$website->id, $websiteData)
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
        $this->user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);
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

    public function test_update_website_access()
    {
        $expectedData = [
            'error' => [
                'message' => 'The name field is required.'
            ]
        ];

        $user = factory(User::class)->create();
        $website = factory(Website::class)->create();
        $user->websites()->attach($website->id, [
            'role' => 'owner'
        ]);

        $filterData = [
            'website_id' => $website->id,
        ];

        $this->actingAs($user)
            ->call('PUT', 'api/v1/websites/'.$website->id, $filterData)
            ->assertJson($expectedData);
        ;
    }

    public function test_update_website_access_failed()
    {
        $expectedData = [
            'error' => [
                'message' => 'You do not have rights to access this resource.'
            ]
        ];

        $user = factory(User::class)->create();
        $website = factory(Website::class)->create();
        $user->websites()->attach($website->id, [
            'role' => 'member'
        ]);

        $filterData = [
            'website_id' => $website->id,
        ];

        $this->actingAs($user)
            ->call('PUT', 'api/v1/websites/'.$website->id, $filterData)
            ->assertStatus(403)
            ->assertJson($expectedData);
    }

    public function test_get_relate_user_websites()
    {
        $expectedData = [];

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $website1 = factory(Website::class)->create([
            'id' => 1,
            'domain' => 'domain1.com',
        ]);
        $website2 = factory(Website::class)->create([
            'id' => 2,
            'domain' => 'domain2.com',
        ]);
        $website3 = factory(Website::class)->create([
            'id' => 3,
            'domain' => 'domain3.com',
        ]);
        $user1->websites()->attach($website1->id, [
            'role' => 'owner'
        ]);
        $user2->websites()->attach($website2->id, [
            'role' => 'owner'
        ]);
        $user3->websites()->attach($website3->id, [
            'role' => 'owner'
        ]);
        $user1->websites()->attach($website2->id, [
            'role' => 'member'
        ]);
        $user1->websites()->attach($website3->id, [
            'role' => 'member'
        ]);

        $r = $this->actingAs($user1)
            ->get('/api/v1/websites/relate');
        dd($r->json());
        $r->assertOk()
            ->assertJson($expectedData);
    }
}
