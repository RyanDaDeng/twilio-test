<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use Facades\App\Services\Twilio\Services\TwilioVerificationService;
use Illuminate\Http\JsonResponse;

class PhoneVerificationApiController extends Controller
{
    public function __construct()
    {
    }

    public function sendCode(SendVerificationCodeRequest $sendVerificationCodeRequest)
    {
        $sendVerificationCodeRequest->validated();

        $res = TwilioVerificationService::sendVerificationCode(
            $sendVerificationCodeRequest->post('phone_number')
        );

        if ($res->isError()) {
            return JsonResponse::create(
                [
                    'status'  => 'error',
                    'message' => $res->getErrorMessage()
                ],
                400
            );
        }

        return JsonResponse::create(
            [
                'status' => 'success',
            ],
            201
        );
    }


    public function verifyCode(VerifyCodeRequest $verifyCodeRequest)
    {
        $verifyCodeRequest->validated();

        $res = TwilioVerificationService::verifyCode($verifyCodeRequest->input('code'), $verifyCodeRequest->input('phone_number'));

        if ($res->isError()) {
            return JsonResponse::create(
                [
                    'status'  => 'error',
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
