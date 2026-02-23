<?php

namespace App\Http\Requests\Certificate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DownloadCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only admins can download
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'lang' => ['sometimes', Rule::in(['en', 'ar'])],
        ];
    }

    /**
     * Resolve the lang parameter from route.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'lang' => $this->route('lang', 'en'),
        ]);
    }
}
