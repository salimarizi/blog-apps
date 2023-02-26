<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Constants\AuthConstant;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function authProcess($role)
    {
        // Register
        User::create(
            AuthConstant::payloadAuthSuccessWithRole(
                "register",
                $role
            )
        );

        // Login
        $responseLogin = $this->post(
            '/api/login',
            AuthConstant::payloadAuthSuccessWithRole("login", $role)
        );

        return $responseLogin["data"]["token"];
    }

    public function storeProcess($token)
    {
        return $this->withHeaders([
            'Accept' => 'text/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(
            '/api/users',
            AuthConstant::payloadAuthSuccessWithRole("register", "normal", true)
        );
    }

    public function test_get_users_unauthenticated(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'text/json'
        ])->get('/api/users');

        $response->assertStatus(401)
            ->assertJson([
                "success" => false,
                "errors" => "Unauthenticated.",
                "data" => null
            ]);
    }

    public function test_get_users_authenticated_as_manager(): void
    {
        $token = $this->authProcess("manager");

        $response = $this->withHeaders([
            'Accept' => 'text/json',
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/users');

        $response->assertStatus(401)
            ->assertJson([
                "success" => false,
                "errors" => "Don't have to access the data",
                "data" => null
            ]);
    }

    public function test_get_users_authenticated_as_admin(): void
    {
        $token = $this->authProcess("admin");

        $response = $this->withHeaders([
            'Accept' => 'text/json',
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/users');

        $response->assertStatus(200);
    }

    public function test_store_user_unauthenticated(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'text/json'
        ])->post('/api/users');

        $response->assertStatus(401)
            ->assertJson([
                "success" => false,
                "errors" => "Unauthenticated.",
                "data" => null
            ]);
    }

    public function test_store_user_authenticated(): void
    {
        $token = $this->authProcess("admin");

        $response = $this->storeProcess($token);

        $response->assertStatus(200);
    }

    public function test_update_user_authenticated(): void
    {
        $token = $this->authProcess("admin");

        $responseStore = $this->storeProcess($token);

        $response = $this->withHeaders([
            'Accept' => 'text/json',
            'Authorization' => 'Bearer ' . $token
        ])->patch(
            '/api/users/' . $responseStore["data"]["id"],
            AuthConstant::payloadAuthSuccessWithRole("register", "normal", true)
        );

        $response->assertStatus(200);
    }

    public function test_delete_user_authenticated(): void
    {
        $token = $this->authProcess("admin");

        $responseStore = $this->storeProcess($token);

        $response = $this->withHeaders([
            'Accept' => 'text/json',
            'Authorization' => 'Bearer ' . $token
        ])->delete('/api/users/' . $responseStore["data"]["id"]);

        $response->assertStatus(200);
    }
}
