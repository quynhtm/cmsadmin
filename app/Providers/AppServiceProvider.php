<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $http = (env('IS_HTTPS',false) == true) ? 'https' : 'http';
        \URL::forceScheme($http);

        if(env('IS_HTTPS',false) == true ){
            \URL::forceRootUrl(env('APP_URL','https://dev-salesnetwork.mcredit.com.vn/'));
            if (str_contains(env('APP_URL','https://dev-salesnetwork.mcredit.com.vn/'), 'https://')) {
                \URL::forceScheme('https');
            }
        }

        /*$this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts(config('elasticquent.config.hosts'))
                ->build();
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
