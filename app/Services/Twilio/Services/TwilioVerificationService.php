<?php

declare(strict_types=1);

namespace App\Services\Twilio\Services;

use App\Services\Twilio\Response\TwilioResponse;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

/**
 * Class VerificationService
 * @package App\Services\Twilio\Services
 */
class TwilioVerificationService
{

    /**
     * @var string $verificationServiceSid
     */
    private $verificationServiceSid;

    /**
     * Twilio Account SID
     *
     * @var String
     */
    public $twilioSid;

    /**
     * Twilio Auth Token
     *
     * @var String
     */
    public $twilioToken;

    /**
     * Twilio Verify SID
     *
     * @var String
     */
    public $verifySid;

    /**
     * TwilioVerificationService constructor.
     * @param Client $client
     */
    public function __construct()
    {

        $this->twilioSid = config('twilio.TWILIO_ACCOUNT_SID');
        $this->twilioToken = config('twilio.TWILIO_AUTH_TOKEN');
        $this->verifySid = config('twilio.TWILIO_VERIFY_SID');

        $this->verificationService = new Client($this->twilioSid, $this->twilioToken);
    }


    /**
     * @param string $number
     * @param string $channel
     * @return TwilioResponse
     */
    public function sendVerificationCode(string $number, string $channel = 'sms'): TwilioResponse
    {

        $response = TwilioResponse::create();

        try {
            $verification = $this
                ->verificationService
                ->verify
                ->v2
                ->services($this->verifySid)
                ->verifications
                ->create($number, $channel);

            return $response
                ->setRawResponse(
                    $verification->toArray()
                )
                ->setResponseSid($verification->sid);

        } catch (TwilioException $exception) {
            Log::error($exception->getMessage());
            return $response
                ->setIsError(true)
                ->setErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $response
                ->setIsError(true)
                ->setErrorMessage($exception->getMessage());
        }
    }

    /**
     * @param string $code
     * @param string $number
     * @return TwilioResponse
     */
    public function verifyCode(string $code, string $number): TwilioResponse
    {
        $response = TwilioResponse::create();

        try {
            $validation = $this
                ->verificationService
                ->verify
                ->v2
                ->services($this->verifySid)
                ->verificationChecks
                ->create(
                    $code,
                    [
                        "to" => $number
                    ]
                );

            if ('approved' === $validation->status) {
                return $response
                    ->setRawResponse(
                        $validation->toArray()
                    )
                    ->setResponseSid(
                        $validation->sid
                    );
            }

            return $response
                ->setRawResponse(
                    $validation->toArray()
                )
                ->setIsError(true)
                ->setErrorMessage('Invalid code.');

        } catch (TwilioException $exception) {
            Log::error($exception->getMessage());
            return $response
                ->setIsError(true)
                ->setErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $response
                ->setIsError(true)
                ->setErrorMessage($exception->getMessage());
        }
    }
}
