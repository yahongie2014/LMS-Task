<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class RegisterRequest extends BaseApiRequest
{
        public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:instructors,email'],
            'phone' => ['nullable', 'string', 'size:11', 'unique:users,phone', 'unique:instructors,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required', 'in:user,instructor'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
