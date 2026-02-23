<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class VerifyOtpRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'size:11'],
            'otp' => ['required', 'string'],
            'type' => ['required', 'in:user,instructor'],
            'device_name' => ['required', 'string'],
        ];
    }
}
