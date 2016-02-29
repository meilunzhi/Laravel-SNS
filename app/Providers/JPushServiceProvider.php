<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JPush;

class JPushServiceProvider extends ServiceProvider
{

    /**
     * 指定是否延缓提供者加载。
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //var_dump($this->app->make('JPush'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('JPush', function($app)
        {
            return new JPush('31b60acaaa6c9a30e83ac013','022a52c7816c68a5919bc3c4',null);
        });
    }

    /**
     * 取得提供者所提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return ['JPush'];
    }
}
