<?php

namespace Tests\Constants;

use App\Models\Role;

class AuthConstant
{
    // Payload for register that will return success response
    public static $payloadRegisterSuccess = [
        'name' => 'normal user',
        'email' => 'normal@blog.com',
        'password' => 'normal123',
        'password_confirmation' => 'normal123'
    ];

    // Payload for register that will return error validation
    public static $payloadRegisterFailed = [
        'name' => 'normal user',
        'email' => 'normal@blog.com',
        'password' => 'normal123'
    ];

    // Payload for login that will return success response
    public static $payloadLoginSuccess = [
        'email' => 'normal@blog.com',
        'password' => 'normal123',
    ];

    // Payload for login that will return invalid credentials
    public static $payloadLoginFailed = [
        'email' => 'normal@blog.com',
        'password' => 'wrong123',
    ];

    // Payload for register/login that will return success response
    public static function payloadAuthSuccessWithRole(
        $type = "login",
        $role = "admin", 
        $addConfirmation = false
    )
    {
        $data = [
            'email' => $role . '@blog.com',
            'password' => $role . '123',
        ];

        if ($type == "login") return $data;
        
        if (!$addConfirmation) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password_confirmation'] = $data['password'];
        }
        
        $data['name'] = $role . ' user';
        $data['role_id'] = Role::where('name', $role)->first()->id;

        return $data;
    }
}
