<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

abstract class BaseApiRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->errorResponse(__('Validation Error'), 422, $errors)
        );
    }

    /**
     * Helper to get JSON payload from a form-data field if needed,
     * or just return the request data if it's already decoded.
     */
    public function jsonPayload($key = null)
    {
        $data = $this->all();
        
        // If it's a JSON string in a field (typical for multipart with nested data)
        if ($key && is_string($this->input($key))) {
            $decoded = json_decode($this->input($key), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $key ? ($data[$key] ?? null) : $data;
    }
}
