<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2020/1/27
 * Time: 2:12 PM
 */

namespace App\Services\Twilio\Providers;


use App\Services\Twilio\Config\TwilioConfig;
use App\Services\Twilio\Config\TwilioConfigInterface;
use App\Services\Twilio\Facades\Twilio;
use App\Services\Twilio\Services\TwilioVerificationService;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Twilio\Rest\Client;

class TwilioServiceProvider extends ServiceProvider implements DeferrableProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TwilioConfigInterface::class,
            TwilioConfig::class
        );


        $this->app->bind(Twilio::SERVICE_NAME, function () {
            $config = app(TwilioConfigInterface::class);
            $client = new Client($config->getSID(), $config->getAuthToken());
            return new TwilioVerificationService($client, app(TwilioConfigInterface::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Twilio::SERVICE_NAME];
    }

}