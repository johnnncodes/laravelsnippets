<?php namespace LaraSnipp\Repo;

use Snippet;
use User;
use Tag;
use LaraSnipp\Repo\Snippet\EloquentSnippetRepository;
use LaraSnipp\Repo\User\EloquentUserRepository;
use LaraSnipp\Repo\Tag\EloquentTagRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind('LaraSnipp\Repo\Snippet\SnippetRepositoryInterface', function ($app) {
            return new EloquentSnippetRepository(
                new Snippet,
                $app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface'),
                $app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
            );
        });

        $app->bind('LaraSnipp\Repo\User\UserRepositoryInterface', function ($app) {
            return new EloquentUserRepository(new User);
        });

        $app->bind('LaraSnipp\Repo\Tag\TagRepositoryInterface', function ($app) {
            return new EloquentTagRepository(new Tag);
        });
    }
}
