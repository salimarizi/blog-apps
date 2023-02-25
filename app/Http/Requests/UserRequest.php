<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public static function rules(string $method): array
    {
        $data = [
            'role_id' => 'required|integer',
            'name' => 'required|string'
        ];

        if ($method === "POST") {
            $data['email'] = 'required|email|unique:users';
            $data['password'] = 'required|string|confirmed';
        } else {
            $data['email'] = 'required|email';
            $data['password'] = 'nullable|string|confirmed';
        }

        return $data;
    }

    public static function registerRules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ];
    }

    public static function loginRules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }
}
