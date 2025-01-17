<?php

namespace App\AddonManager;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        AddonManager::getInstance($this->app);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('addonManager', function ($app) {
            return AddonManager::getInstance($app);
        });
    }
}
