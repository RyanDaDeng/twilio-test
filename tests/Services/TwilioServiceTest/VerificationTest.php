<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 1:35 PM
 */

namespace Tests\Services\TwilioServiceTest;


use App\Services\Twilio\Facades\Twilio;
use App\Services\Twilio\Services\TwilioVerificationService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Twilio\Rest\Client;

class VerificationTest extends TestCase
{

    use WithoutMiddleware;


    public function testSendVerificationCode()
    {

        $res = Twilio::sendVerificationCode('+61404157872');

    }


    public function testVerifyCode()
    {
    }
}