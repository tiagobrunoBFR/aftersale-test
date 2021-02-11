<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_status_code_201_and_user_created_when_params_is_valid()
    {
        $data = [
            'name' => 'Teste',
            'email' => 'test@email.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];


        $response = $this->json('POST','api/users', $data);
        $response->assertStatus(201);
        $result = json_decode($response->content());
        $this->assertEquals($data['name'], $result->user->name);
        $this->assertEquals($data['email'], $result->user->email);
    }

    /**
     * @test
     */
    public function should_return_status_code_422_when_email_exists_in_database()
    {
       User::factory()->create(['email' => 'test@email.com']);

        $data = [
            'name' => 'Teste',
            'email' => 'test@email.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];


        $response = $this->json('POST','api/users', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @test
     * @dataProvider providerErrors
     */
    public function should_return_status_code_422($data, $inputErro)
    {
        $response = $this->json('POST','api/users', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($inputErro);
    }


    public function providerErrors()
    {

        return [
            'when name is blank' => [
                'data' => [
                    'name' => '',
                ],
                'inputErro' => 'name'
            ],
            'when email is blank' => [
                'data' => [
                    'email' => '',
                ],
                'inputErro' => 'email'
            ],
            'when email is invalid' => [
                'data' => [
                    'email' => 'test',
                ],
                'inputErro' => 'email'
            ],
            'when password is blank' => [
                'data' => [
                    'password' => '',
                ],
                'inputErro' => 'password'
            ],
            'when passsword and password confirmation is different' => [
                'data' => [
                    'password' => '1234',
                    'password_confirmation' => '123',
                ],
                'inputErro' => 'password'
            ],
        ];
    }
}
