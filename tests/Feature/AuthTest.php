<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Constants\AuthConstant;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function registerProcess()
    {
        return $this->post(
            '/api/register',
            AuthConstant::$payloadRegisterSuccess
        );
    }

    public function test_register_password_not_confirmed(): void
    {
        $response = $this->post('/api/register', AuthConstant::$payloadRegisterFailed);

        $response->assertStatus(400)
            ->assertJson([
                "success" => false,
                "errors" => [
                    "The password field confirmation does not match."
                ],
                "data" => null
            ]);
    }

    public function test_register_success(): void
    {
        $response = $this->registerProcess();

        $response->assertStatus(200);
    }

    public function test_login_failed(): void
    {
        // Register first
        $this->registerProcess();

        // Login
        $response = $this->post('/api/login', AuthConstant::$payloadLoginFailed);

        $response->assertStatus(401)
            ->assertJson([
                "success" => false,
                "errors" => "Invalid credentials",
                "data" => null
            ]);
    }

    public function test_login_success(): void
    {
        // Register first
        $this->registerProcess();

        // Login
        $response = $this->post('/api/login', AuthConstant::$payloadLoginSuccess);

        $response->assertStatus(200);
    }
}
