<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 2:14 PM
 */

namespace App\Services\Twilio\Facades;


use App\Services\Twilio\Response\TwilioResponse;
use App\Services\Twilio\Services\TwilioVerificationService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static TwilioResponse sendVerificationCode(string $number, string $channel = 'sms'):
 * @method static TwilioResponse verifyCode(string $code, string $number)
 * @method static TwilioResponse createVerificationService(string $serviceName)
 * @method static TwilioVerificationService setVerificationServiceByConfig(string $serviceKey = null)
 * @method static TwilioVerificationService setVerificationServiceId(string $sid)
 * Class Twilio
 * @package App\Services\Twilio\Facades
 * @see TwilioVerificationService
 */
class Twilio extends Facade
{
    public const SERVICE_NAME = 'Twilio';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return self::SERVICE_NAME;
    }
}