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
        \Braintree_Configuration::merchantId('whf3gmyr4j2ycfmh');
        \Braintree_Configuration::publicKey('4cx4hfp5zvq3hmcg');
        \Braintree_Configuration::privateKey('a115c0b7ca8f07ebc8bbe40d92bd4dab');
                //
    }
}
