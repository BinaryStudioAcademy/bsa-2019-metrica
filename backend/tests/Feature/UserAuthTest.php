<?php

namespace Tests\Feature;

use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        factory(User::class)->create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
    }

    public function testSuccessLogin()
    {
        $response = $this->json('POST', 'api/v1/auth/login', [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

    public function testFailLogin()
    {
        $response = $this->json('POST', 'api/v1/auth/login', [
            'email' => 'test@gmail.com11',
            'password' => 'secret1234',
        ]);
        $response->assertStatus(400);

        $this->assertEquals('User doesn\'t exist', $response->json('error.message'));
        $response->assertJsonStructure([
                'error'
        ]);
    }
}
