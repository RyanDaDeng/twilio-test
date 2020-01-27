<?php

use Illuminate\Support\Str;

return [
    'SID'                   => env('TWILIO_SID', ''),
    'AUTH_TOKEN'            => env('TWILIO_AUTH_TOKEN', ''),
    'SENDER_NUMBER'         => env('TWILIO_SENDER_NUMBER', ''),
    'VERIFICATION_SERVICES' => [
        'MY_APP' => ''
    ]
];