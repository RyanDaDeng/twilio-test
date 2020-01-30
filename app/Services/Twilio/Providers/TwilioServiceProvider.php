<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 2:12 PM
 */

namespace App\Services\Twilio\Providers;

use Facades\App\Services\Twilio\Services\TwilioVerificationService;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class TwilioServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public const SERVICE_NAME = 'TwilioVerificationService';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(self::SERVICE_NAME, function () {
            return new TwilioVerificationService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [self::SERVICE_NAME];
    }
}
