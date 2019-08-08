<?php

namespace Tests\Feature;

use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        User::where('email','test@gmail.com')->delete();
        User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
    }

    public function testSuccessLogin()
    {
        $response = $this->json('POST','api/v1/auth/login',[
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
        $response = $this->json('POST','api/v1/auth/login',[
            'email' => 'test@gmail.com11',
            'password' => 'secret1234',
        ]);
        $response->assertStatus(404);
        $this->assertEquals('User with this email not found', $response->json('error'));
        $response->assertJsonStructure([
                'error'
        ]);

    }
}
