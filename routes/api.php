<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'verification'], function () {
        Route::post('', [
            'uses' => 'PhoneVerificationApiController@sendCode',
            'as' => 'verification.sendCode',
        ]);

        Route::get('/{code}', [
            'uses' => 'PhoneVerificationApiController@verifyCode',
            'as' => 'verification.verifyCode',
        ]);

    });
});
