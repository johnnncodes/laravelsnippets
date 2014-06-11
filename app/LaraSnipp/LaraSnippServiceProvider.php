<?php namespace LaraSnipp;

use App;
use Illuminate\Support\ServiceProvider;
// use Redis;
use View;

// use Tag;

class LaraSnippServiceProvider extends ServiceProvider
{
    protected $deferred = true;

    public function register()
    {
        App::bind("larasnipp.command.comments", function () {
            return new Command\CommentsCommand();
        });

        $this->commands(
            "larasnipp.command.comments"
        );
    }

    /**
     * Bootstrap the application
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        // $app->singleton('redis', function()
        // {
        //     return Redis::connection();
        // });

        $this->_bootComposers();
    }

    private function _bootComposers()
    {
    }

    public function provides()
    {
        return [
            "larasnipp.command.comments"
        ];
    }

}
