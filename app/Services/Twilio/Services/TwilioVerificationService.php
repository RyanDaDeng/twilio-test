<?php

declare(strict_types=1);

namespace App\Services\Twilio\Services;

use App\Services\Twilio\Config\TwilioConfigInterface;
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
     * @var Client $client
     */
    private $client;
    /**
     * @var string $verificationServiceSid
     */
    private $verificationServiceSid;

    /**
     * @var TwilioConfigInterface $config
     */
    private $config;

    /**
     * TwilioVerificationService constructor.
     * @param Client $client
     * @param TwilioConfigInterface $twilioConfig
     */
    public function __construct(
        Client $client,
        TwilioConfigInterface $twilioConfig
    )
    {
        $this->config = $twilioConfig;
        $this->client = $client;
        $this->verificationServiceSid = $this->setVerificationServiceByConfig();
    }


    /**
     * @param string|null $serviceKey
     * @return string
     */
    public function setVerificationServiceByConfig(string $serviceKey = null): string
    {
        $this->verificationServiceSid = $this->config->getVerificationSid($serviceKey);
        return $this->verificationServiceSid;
    }

    /**
     * @param string $sid
     * @return TwilioVerificationService
     */
    public function setVerificationServiceId(string $sid): self
    {
        $this->verificationServiceSid = $sid;
        return $this;
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
                ->client
                ->verify
                ->v2
                ->services($this->verificationServiceSid)
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
                ->client
                ->verify
                ->v2
                ->services($this->verificationServiceSid)
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

    /**
     * @param $serviceName
     * @return TwilioResponse
     */
    public function createVerificationService(string $serviceName): TwilioResponse
    {

        $response = TwilioResponse::create();
        try {
            $service = $this
                ->client
                ->verify
                ->v2
                ->services
                ->create($serviceName);

            return $response
                ->setRawResponse(
                    $service->toArray()
                )
                ->setResponseSid($service->sid);

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