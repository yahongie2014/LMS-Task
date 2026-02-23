<?php

namespace App\Http\Requests\Certificate;

use App\Repositories\Interfaces\CertificateRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GenerateCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [];
    }

    /**
     * Additional validation after standard rules pass.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $course = $this->route('course');
            $user = $this->user();
            $repo = app(CertificateRepositoryInterface::class);

            if (!$repo->hasCompletedCourse($user, $course)) {
                $validator->errors()->add('course', __('messages.course_not_completed'));
            }
        });
    }
}
