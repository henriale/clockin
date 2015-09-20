<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade as Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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

    }
}
