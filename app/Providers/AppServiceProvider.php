<?php

namespace App\Providers;

use \Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Blade as Blade;
use \App\Http\Controllers\JsonApi\LumenIntegration;
use \Neomerx\Limoncello\Http\AppServiceProviderTrait;
use \Neomerx\Limoncello\Contracts\IntegrationInterface;

class AppServiceProvider extends ServiceProvider
{
    use AppServiceProviderTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('formatTime', function($expression) {
            return "<?php
                if(empty{$expression})
                    echo '-';
                else
                    echo with{$expression}->format('H:i');
            ?>";
        });
    }

    public function register()
    {
        $integration = new LumenIntegration();

        $this->registerResponses($integration);
        $this->registerCodecMatcher($integration);
        $this->registerExceptionThrower($integration);

        $this->app->bind(IntegrationInterface::class, function () {
            return new LumenIntegration();
        });
    }
}
