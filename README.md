## Simple Install

1. composer install -vvv && php artisan key:generate
2. Go to config/twilio.php, complete all credentials.
    ````
      TWILIO_ACCOUNT_SID=
      TWILIO_AUTH_TOKEN"=
      TWILIO_VERIFY_SID=
    ````
3. `php artisan migrate`
4. `php artisan passport:install`
5. Simple laravel built-in server `php artisan serve`
6. POST `/api/register` - register an account and copy token or POST `/api/login` login
7. POST `api/v1/verification` - use Bearer Token and send SMS code
8. POST `/api/v1/verification-code` - verify code

## Api

Located at `Http/Controllers/Api/PhoneVerificationApiController`

## Service

Located at `Services/Twilio`

## Tests

Located at `tests/Feature/VerificationTest`

                             
## Some useful packages for future improvements

- Official Twilio Laravel demo project: https://github.com/TwilioDevEd/verify-v2-quickstart-php
- Extended laravel notification channel for Twilio: https://github.com/laravel-notification-channels/twilio
- Laravel Phone number validation: https://github.com/Propaganistas/Laravel-Phone