<?php

namespace App\Http\Requests\Api\Student;

use App\Http\Requests\Api\BaseApiRequest;

class UpdateProfileRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'phone' => ['nullable', 'string', 'size:12', 'unique:users,phone,' . auth()->id()],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
