<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Generate and save OTP for a phone number and model.
     */
    public function generateOtp($phone, $model = null, bool $isNew = false)
    {
        $otpCode = rand(100000, 999999);
        $data = [
            'phone' => $phone,
            'otp' => $otpCode,
            'is_new' => $isNew,
            'expires_at' => Carbon::now()->addMinutes(10),
        ];

        if ($model) {
            $model->otps()->create($data);
        } else {
            \App\Models\Otp::create($data);
        }

        // MOCK: Sending OTP via SMS
        Log::info("OTP for {$phone}: {$otpCode}");
        
        return $otpCode;
    }

    /**
     * Verify OTP for a phone number.
     */
    public function verifyOtp($phone, $otpCode)
    {
        $otp = \App\Models\Otp::where('phone', $phone)
            ->where('otp', $otpCode)
            ->whereNull('verified_at')
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if ($otp) {
            $otp->update(['verified_at' => Carbon::now()]);
            return $otp;
        }

        return false;
    }
}
