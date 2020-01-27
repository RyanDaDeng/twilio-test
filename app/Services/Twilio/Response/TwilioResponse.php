<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 1:28 PM
 */

declare(strict_types=1);

namespace App\Services\Twilio\Response;

/**
 * Class TwilioResponse
 * @package App\Services\Twilio\Response
 */
class TwilioResponse
{
    /**
     * @var bool $isError
     */
    private $isError = false;

    /**
     * @var string $errorMessage
     */
    private $errorMessage = '';

    /**
     * @var string $responseSid
     */
    private $responseSid = '';

    /**
     * @var $rawResponse
     */
    private $rawResponse;

    /**
     * @return TwilioResponse
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->isError;
    }

    public function isSuccess(): bool
    {
        return !$this->isError;
    }

    /**
     * @param bool $isError
     * @return TwilioResponse
     */
    public function setIsError(bool $isError)
    {
        $this->isError = $isError;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return TwilioResponse
     */
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseSid(): string
    {
        return $this->responseSid;
    }

    /**
     * @param string $responseSid
     * @return TwilioResponse
     */
    public function setResponseSid(string $responseSid): self
    {
        $this->responseSid = $responseSid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @param mixed $rawResponse
     * @return TwilioResponse
     */
    public function setRawResponse(array $rawResponse): self
    {
        $this->rawResponse = $rawResponse;
        return $this;
    }

}