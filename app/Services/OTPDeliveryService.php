<?php

namespace App\Services;


use Illuminate\Support\Facades\Mail;
use App\Mail\OTPSent;
use Twilio\Rest\Client; // For SMS
use Kreait\Firebase\Messaging\CloudMessage; // For push notifications

class OTPDeliveryService
{
    protected $twilioClient;
    protected $firebaseMessaging;

    public function __construct()
    {
        // Initialize Twilio client
        // $this->twilioClient = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        // Initialize Firebase Messaging
        // $this->firebaseMessaging = app('firebase.messaging');
        return 1 ;
    }

    /**
     * Send OTP via Email.
     */
    public function sendViaEmail($email, $otp)
    {
        Mail::to($email)->send(new OTPSent($otp));
    }

    /**
     * Send OTP via SMS using Twilio.
     */
    public function sendViaSMS($phoneNumber, $otp)
    {
       /* $this->twilioClient->messages->create(
            $phoneNumber,
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => __('validation.otp_message', ['otp' => $otp]),
            ]
        );
       */
        return 1 ;
    }

    /**
     * Send OTP via Push Notification using Firebase.
     */
    public function sendViaPushNotification($deviceToken, $otp)
    {
        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [
                'title' => __('messages.otp_title'),
                'body' => __('messages.otp_message', ['otp' => $otp]),
            ],
        ]);

        $this->firebaseMessaging->send($message);

        return 1 ;
    }

    // Send OTP
    public function sendOtp($customer, $otp)
    {
        // if ($customer->otp_delivery_method == "email") {
        //     $this->sendViaEmail($customer->email, $otp);
        // } else {
        //     $this->sendViaSMS($customer->mobile_number, $otp);
        // }
        $this->sendViaSMS($customer, $otp);
    }
}
