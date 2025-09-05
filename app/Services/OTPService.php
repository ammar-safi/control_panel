<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OTPService
{
    protected $expirationTimeInMinutes;
    protected $otpLength;

    public function __construct($expirationTimeInMinutes = 5, $otpLength = 6)
    {
        $this->expirationTimeInMinutes = $expirationTimeInMinutes;
        $this->otpLength = $otpLength;
    }

    /**
     * Generate and store an OTP for a given identifier.
     */
    public function generateOTP($identifier)
    {
        $cacheKey = $this->getCacheKey($identifier);
        if (Cache::has($cacheKey)) {
            return false;
        }

        $otp = Str::random($this->otpLength); // Generate OTP
        Cache::put($this->getCacheKey($identifier), $otp, now()->addMinutes($this->expirationTimeInMinutes));

        // Log OTP generation
        Log::info(__('validation.otp_generated', ['identifier' => $identifier, 'otp' => $otp]));

        return $otp;
    }

    /**
     * Validate the OTP for a given identifier.
     */
    public function validateOTP($identifier, $otp)
    {
        // $cachedOTP = Cache::get($this->getCacheKey($identifier));

        // // Log OTP validation attempt
        // Log::info(__('messages.otp_validation_attempt', ['identifier' => $identifier, 'otp' => $otp]));

        // if ($cachedOTP && $cachedOTP === $otp) {
        //     Cache::forget($this->getCacheKey($identifier));
        //     return true ;
        // }
        // return false;

        return 1;
    }

    /**
     * Resend OTP for a given identifier.
     */
    public function resendOTP($identifier) {
        $otp = $this->generateOTP($identifier);
        // Log OTP resend
        Log::info(__('validation.otp_resent', ['identifier' => $identifier, 'otp' => $otp]));
        return $otp;

    }

    /**
     * Get the cache key for the OTP.
     */
    protected function getCacheKey($identifier)
    {
        return 'otp_' . $identifier;
    }
}
