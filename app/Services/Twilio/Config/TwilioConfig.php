<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 2:24 PM
 */

namespace App\Services\Twilio\Config;


use Illuminate\Support\Collection;

class TwilioConfig implements TwilioConfigInterface
{

    public function getSID(): string
    {
        return config('twilio.SID');
    }

    public function getAuthToken(): string
    {
        return config('twilio.AUTH_TOKEN');
    }

    public function getSenderNumber(): string
    {
        return config('twilio.TWILIO_SENDER_NUMBER');
    }

    public function getVerificationSid($serviceName = null): string
    {
        $data = config('twilio.VERIFICATION_SERVICES');

        if (!empty($serviceName) && isset($data[$serviceName])) {
            return $data[$serviceName];
        }
        return Collection::make($data)->first();
    }
}