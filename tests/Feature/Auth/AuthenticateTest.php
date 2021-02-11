<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function should_authenticate_the_user_and_return_token_when_credentials_is_valid()
    {
        User::factory()->create([
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $credentials = [
            'email' => 'test@email.com',
            'password' => '123456'
        ];

        $response = $this->json('POST','api/authenticate', $credentials);
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     * @test
     */
    public function should_return_error_unauthorized_and_status_code_401_when_credentials_is_not_valid()
    {
        User::factory()->create([
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $credentials = [
            'email' => 'test@email.com',
            'password' => '123'
        ];

        $response = $this->json('POST','api/authenticate', $credentials);
        $response->assertStatus(401);
        $this->assertEquals(['error' => 'Unauthorized'], $response->json());
    }
}
