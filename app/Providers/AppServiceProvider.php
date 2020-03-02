<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Braintree_Configuration::environment('sandbox');
        \Braintree_Configuration::merchantId('x3k6xjzfj4hqr5wr');
        \Braintree_Configuration::publicKey('zzwvcm45v35b8ffd');
        \Braintree_Configuration::privateKey('fa2b6cf395aefad9fbc1905d249fbef5');
                //
    }
}
