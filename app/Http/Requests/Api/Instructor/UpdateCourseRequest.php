<?php

namespace App\Http\Requests\Api\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title_en' => 'sometimes|string',
            'title_ar' => 'sometimes|string',
            'description_en' => 'sometimes|string',
            'description_ar' => 'sometimes|string',
            'level' => 'sometimes|string',
            'price' => 'numeric',
            'duration' => 'integer',
        ];
    }
}
