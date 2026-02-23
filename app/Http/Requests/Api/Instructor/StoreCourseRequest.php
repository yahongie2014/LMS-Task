<?php

namespace App\Http\Requests\Api\Instructor;

use App\Http\Requests\Api\BaseApiRequest;

class StoreCourseRequest extends BaseApiRequest
{
        public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'level' => 'required|string',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
        ];
    }
}
