<?php

namespace Arthurmelikyan\Quizable;

use Illuminate\Support\ServiceProvider;

class QuizableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'arthurmelikyan');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'arthurmelikyan');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once __DIR__ . '/../vendor/autoload.php';
        }

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/quizable.php', 'quizable');

        // Register the service the package provides.
        $this->app->singleton('quizable', function ($app) {
            return new Quizable;
        });
        // $this->publishes([
        //     __DIR__.'/../public' => public_path('vendor/quizable'),
        // ], 'public');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['quizable'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/quizable.php' => config_path('quizable.php'),
        ], 'quizable.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/arthurmelikyan'),
        ], 'quizable.views');*/

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/quizable'),
        ], 'quizable.assets');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/quizable'),
        ], 'quizable.views');*/

        // Publishing the migration files.

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations/'.config('quizable.migrations_publish_path')),
        ], 'quizable.migrations');


        // Registering package commands.
        // $this->commands([]);
    }
}
