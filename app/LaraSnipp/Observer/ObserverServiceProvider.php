<?php namespace LaraSnipp\Observer;

use LaraSnipp\Mailers\UserMailer;
use User;
use Snippet;
use LaraSnipp\Observer\User\UserObserver;
use LaraSnipp\Observer\Snippet\SnippetObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        User::observe(new UserObserver(new UserMailer));
        Snippet::observe(new SnippetObserver);
    }
}
