## Simple Install

1. composer install -vvv && php artisan key:generate
2. Go to config/twilio.php, complete all credentials.
    ````
    TWILIO_SID=
    TWILIO_AUTH_TOKEN=
    TWILIO_SENDER_NUMBER=
    TWILIO_VERIFICATION_SERVICE=
    ````
3. `php artisan migrate`
4. `php artisan passport:install`
5. POST `/api/register` - register an account and copy token or POST `/api/login` login
6. Simple laravel built-in server `php artisan serve`
7. POST `api/v1/verification` - use Bearer Token and send SMS code
8. GET `/api/v1/verification/{code}` - verify code

## Api

Located at `Http/Controllers/Api/PhoneVerificationApiController`

## Service

Located at `Services/Twilio`

## Tests

Located at `tests/Feature/VerificationTest`


## Assumptions

- In the given requirement, the user is not required to send phone number again to verify code, so I put phone number in Cache and bind it to User ID.
- Using Bearer token for API authorization.
- Assuming send SMS verification is `POST api/v1/verification`
- Assuming Verify Code URI is `GET /api/v1/verification/{code}`
                             
## Some useful packages for future improvements

- Official Twilio Laravel demo project: https://github.com/TwilioDevEd/verify-v2-quickstart-php
- Extended laravel notification channel for Twilio: https://github.com/laravel-notification-channels/twilio
- Laravel Phone number validation: https://github.com/Propaganistas/Laravel-Phone