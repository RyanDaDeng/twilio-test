<?php


namespace Tests\Feature;


use Facades\App\Services\Twilio\Services\TwilioVerificationService;
use App\Services\Twilio\Response\TwilioResponse;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class VerificationTest extends TestCase
{

    use WithoutMiddleware;

    public function testSendVerificationCodeNotValidPhone()
    {
        $user = factory(User::class)->make();

        $res = $this->actingAs($user)->post('/api/v1/verification', [
            'phone_number' => '+6122'
        ]);
        $this->assertEquals(422, $res->status());
    }


    public function testSendCorrectPhoneNumberWithIncorrectResponse()
    {
        $user = factory(User::class)->make();

        TwilioVerificationService::shouldReceive('sendVerificationCode')
            ->with('+61404157872')
            ->once()
            ->andReturn(
                TwilioResponse::create()
                    ->setIsError(true)
                    ->setErrorMessage('failed')
            );

        $res = $this->actingAs($user)
            ->post(
                '/api/v1/verification',
                [
                    'phone_number' => '+61404157872'
                ]
            );
        $res->assertStatus(400)
            ->assertJson(
                [
                    'status'  => 'error',
                    'message' => 'failed'
                ]
            );
    }


    public function testSendCorrectPhoneNumberWithCorrectResponse()
    {
        $user = factory(User::class)->make();

        TwilioVerificationService::shouldReceive('sendVerificationCode')
            ->with('+61404157872')
            ->once()
            ->andReturn(
                TwilioResponse::create()
            );

        $res = $this->actingAs($user)
            ->post(
                '/api/v1/verification', [
                    'phone_number' => '+61404157872'
                ]
            );

        $res->assertStatus(201)
            ->assertJson(
                [
                    'status' => 'success',
                ]
            );
    }


    public function testVerifyCorrectCode()
    {
        $user = factory(User::class)->make();

        TwilioVerificationService::shouldReceive('verifyCode')
            ->with('123456', '+61404157872')
            ->once()
            ->andReturn(
                TwilioResponse::create()
            );

        $res = $this->actingAs($user)
            ->post('/api/v1/verification-code', ['code' => '123456', 'phone_number' => '+61404157872']);

        $res->assertStatus(200)
            ->assertJson(
                [
                    'status' => 'success',
                ]
            );
    }


    public function testVerifyNoPhoneNumber()
    {
        $user = factory(User::class)->make();

        $res = $this->actingAs($user)
            ->post('/api/v1/verification-code', ['code' => '123456']);

        $res->assertStatus(422)
            ->assertJson(
                [
                    'errors' => [
                        'phone_number' => ['The phone number field is required.']
                     ]
                ]
            );
    }
}
