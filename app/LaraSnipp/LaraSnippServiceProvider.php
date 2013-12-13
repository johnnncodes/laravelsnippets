<?php namespace LaraSnipp;

use Illuminate\Support\ServiceProvider;
use Redis;
use View;
use Tag;

class LaraSnippServiceProvider extends ServiceProvider {

    public function register() {}

    /**
     * Bootstrap the application
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $app->singleton('redis', function()
        {
            return Redis::connection();
        });

        $this->_bootComposers();
    }

    private function _bootComposers()
    {
        View::composer('layouts.master', 'LaraSnipp\Composer\LayoutMasterComposer');
    }

}