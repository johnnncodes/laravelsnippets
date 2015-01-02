<?php namespace LaraSnipp\Service\Form;

use Illuminate\Support\ServiceProvider;
use LaraSnipp\Service\Form\User\UserForm;
use LaraSnipp\Service\Form\User\UserFormLaravelValidator;
use LaraSnipp\Service\Form\Snippet\SnippetForm;
use LaraSnipp\Service\Form\Snippet\SnippetFormLaravelValidator;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->bind('LaraSnipp\Service\Form\User\UserForm', function ($app) {
            return new UserForm(
                new UserFormLaravelValidator($app['validator']),
                $app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
            );
        });

        $app->bind('LaraSnipp\Service\Form\Snippet\SnippetForm', function ($app) {
            return new SnippetForm(
                new SnippetFormLaravelValidator($app['validator']),
                $app->make('LaraSnipp\Repo\Snippet\SnippetRepositoryInterface'),
                $app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface')
            );
        });
    }

}
