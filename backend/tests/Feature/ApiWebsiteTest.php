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
                'id' => 4,
                'name' => $this->faker->name,
                'domain' => $this->faker->domainName,
                'single_page' => true,
                'tracking_number' => '00000001',
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
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $website1 = factory(Website::class)->create([
            'id' => 1,
            'name' => 'name1',
            'domain' => 'domain1.com',
        ]);
        $website2 = factory(Website::class)->create([
            'id' => 2,
            'name' => 'name2',
            'domain' => 'domain2.com',
        ]);

        $user1->websites()->attach($website1->id, [
            'role' => 'owner',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
        ]);
        $user2->websites()->attach($website2->id, [
            'role' => 'owner',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
        ]);
        $user1->websites()->attach($website2->id, [
            'role' => 'member',
            'permitted_menu' => "visitors, page-views, geo-location",
        ]);
        $user3->websites()->attach($website1->id, [
            'role' => 'member',
            'permitted_menu' => "visitors, page-views",
        ]);

        $expectedData = [
            "data" => [
                [
                    'id' => $website1->id,
                    'name' => $website1->name,
                    'domain' => $website1->domain,
                    'single_page' => $website1->single_page,
                    'tracking_number' => $website1->tracking_number,
                    'role' => 'owner',
                    'permitted_menu' => "visitors, page-views, geo-location, behaviour, screencast",
                ],
                [
                    'id' => $website2->id,
                    'name' => $website2->name,
                    'domain' => $website2->domain,
                    'single_page' => $website2->single_page,
                    'tracking_number' => $website2->tracking_number,
                    'role' => 'member',
                    'permitted_menu' => "visitors, page-views, geo-location",
                ]
            ],
            "meta" => []
        ];

        $this->actingAs($user1)
            ->call('GET', '/api/v1/websites/all')
            ->assertOk()
            ->assertJson($expectedData);
    }
}
