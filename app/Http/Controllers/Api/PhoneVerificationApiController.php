<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Services\Twilio\Facades\Twilio;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PhoneVerificationApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sendCode(SendVerificationCodeRequest $sendVerificationCodeRequest)
    {
        $sendVerificationCodeRequest->validated();

        $res = Twilio::sendVerificationCode(
            $sendVerificationCodeRequest->post('phone_number')
        );

        if ($res->isError()) {
            return JsonResponse::create(
                [
                    'status' => 'error',
                    'message' => $res->getErrorMessage()
                ],
                400
            );
        }
        Cache::put(
            'user_verification_' . Auth::user()->getAuthIdentifier(),
            $sendVerificationCodeRequest->post('phone_number'),
            3600
        );

        return JsonResponse::create(
            [
                'status' => 'success',
            ],
            201
        );
    }


    public function verifyCode(VerifyCodeRequest $verifyCodeRequest, $code)
    {
        $verifyCodeRequest->validated();

        $key = 'user_verification_' . Auth::user()->getAuthIdentifier();

        $phoneNumber = Cache::get($key);

        if (empty($phoneNumber)) {
            return JsonResponse::create(
                [
                    'status' => 'error',
                    'message' => 'No phone number.'
                ],
                400
            );
        }

        $res = Twilio::verifyCode($code, $phoneNumber);
        Cache::pull($key);

        if ($res->isError()) {
            return JsonResponse::create(
                [
                    'status' => 'error',
                    'message' => $res->getErrorMessage()
                ],
                400
            );
        }

        return JsonResponse::create(
            [
                'status' => 'success',
            ],
            200
        );
    }
}