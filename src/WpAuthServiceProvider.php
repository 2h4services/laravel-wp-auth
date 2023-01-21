<?php

namespace twoh4services\LaravelWpAuth;

use Illuminate\Support\ServiceProvider;
use twoh4services\LaravelWpAuth\Providers\WordPressUserProvider;

class WpAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('wordpress', function ($app, array $config) {
            return new WordPressUserProvider();
        });
    }
}