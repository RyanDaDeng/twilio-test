<?php


namespace Tests\Feature;


use App\Services\Twilio\Facades\Twilio;
use App\Services\Twilio\Response\TwilioResponse;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Cache;
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

        Twilio::shouldReceive('sendVerificationCode')
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

        $number = Cache::get('user_verification_' . $user->id);
        $this->assertEquals(null, $number);
    }


    public function testSendCorrectPhoneNumberWithCorrectResponse()
    {
        $user = factory(User::class)->make();

        Twilio::shouldReceive('sendVerificationCode')
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

        $number = Cache::get('user_verification_' . $user->id);
        $this->assertEquals('+61404157872', $number);
    }


    public function testVerifyCorrectCode()
    {
        $user = factory(User::class)->make();

        Cache::shouldReceive('get')
            ->with('user_verification_' . $user->id)
            ->once()
            ->andReturn(
                '+61404157872'
            );

        Cache::shouldReceive('pull')
            ->with('user_verification_' . $user->id)
            ->once()
            ->andReturn(true);

        Twilio::shouldReceive('verifyCode')
            ->with('123456', '+61404157872')
            ->once()
            ->andReturn(
                TwilioResponse::create()
            );

        $res = $this->actingAs($user)
            ->post('/api/v1/verification-code', ['code' => '123456']);

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

        $res->assertStatus(400)
            ->assertJson(
                [
                    'status'  => 'error',
                    'message' => 'No phone number.',
                ]
            );
    }
}