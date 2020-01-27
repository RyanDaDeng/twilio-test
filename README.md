## Simple Install

1. Go to config/twilio.php, complete all credentials.
2. php artisan migrate
3. php artisan passport:install
4. POST `/api/register` - register an account and copy token
5. POST `api/v1/verification` - use Bearer Token and send SMS code
6. GET `/api/v1/verification/{code}` - verify code

## Api

Located at `Http/Controllers/Api/PhoneVerificationApiController`

## Service

Located at `Services/Twilio`

## Tests

Located at `tests/Feature/VerificationTest`