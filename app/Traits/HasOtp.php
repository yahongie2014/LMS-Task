<?php

namespace App\Traits;

use App\Models\Otp;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasOtp
{
    /**
     * Get all of the model's OTPs.
     */
    public function otps(): MorphMany
    {
        return $this->morphMany(Otp::class, 'customable');
    }

    /**
     * Get the latest OTP for the model.
     */
    public function latestOtp()
    {
        return $this->otps()->latest()->first();
    }
}
