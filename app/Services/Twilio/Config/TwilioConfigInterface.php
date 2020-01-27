<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 2:24 PM
 */

namespace App\Services\Twilio\Config;

interface TwilioConfigInterface
{
    public function getSID(): string;

    public function getAuthToken(): string;

    public function getSenderNumber(): string;

    public function getVerificationSid($serviceName = null): string;
}