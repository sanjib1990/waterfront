<?php

namespace App\Providers;

use App\Utils\Factory;
use League\Fractal\Manager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerObjects();
        $this->booContracts();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'prod') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Register the custom macros for application
     *
     * @return void
     */
    private function registerObjects()
    {
        // Singleton for Fractal
        $this->app->singleton('League\Fractal\Manager', function () {
            return new Manager();
        });

        // Singleton for Resource factory
        $this->app->singleton('App\Utils\Factory', function () {
            return new Factory('League\\Fractal\\Resource');
        });
        
        /**
         * Macro for response
         */
        $this
            ->app
            ->make(ResponseFactory::class)
            ->macro('jsend', function ($data = null, $message = null, $code = 200, $status = 'success') {
                if ($message instanceof MessageBag) {
                    $message = $message->first();
                }

                if ($code >= 200 && $code < 300) {
                    $status = 'success';
                } elseif ($code >= 400 && $code < 500) {
                    $status = 'fail';
                } elseif ($code >= 500) {
                    $status = 'error';
                }

                return $this->json([
                    'status'    => $status,
                    'message'   => $message,
                    'data'      => $data
                ], $code);
            });
    }

    /**
     * Boot all the contracts with the application.
     *
     * @return void
     */
    private function booContracts()
    {
        $this->app->bind(
            'App\Contracts\RelationContract',
            'App\Models\Relation'
        );
        $this->app->bind(
            'App\Contracts\PersonContract',
            'App\Models\Person'
        );
        $this->app->bind(
            'App\Contracts\ApiAuthenticateContract',
            'App\Utils\JwtAuthenticator'
        );
    }
}
