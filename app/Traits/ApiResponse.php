<?php

namespace App\Traits;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'currency' => Setting::getValue('currency', env("CURRENCY")),
            'data' => $data,
        ], $code);
    }

    /**
     * Error Response.
     *
     * @param string $message
     * @param int $code
     * @param mixed|null $errors
     * @return JsonResponse
     */
    protected function errorResponse($message, $code, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
