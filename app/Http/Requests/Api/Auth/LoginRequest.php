<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class LoginRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'type' => ['required', 'in:user,instructor'],
            'device_name' => ['required', 'string'],
        ];
    }
}
