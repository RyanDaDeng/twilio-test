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
