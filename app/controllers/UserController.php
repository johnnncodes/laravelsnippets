<?php

use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;

class UserController extends BaseController
{
    /**
     * Snippet repository
     *
     * @var \LaraSnipp\Repo\Snippet\SnippetRepositoryInterface
     */
    protected $snippet;

    /**
     * User repository
     *
     * @var \LaraSnipp\Repo\Snippet\UserRepositoryInterface
     */
    protected $user;

    public function __construct(UserRepositoryInterface $user, SnippetRepositoryInterface $snippet)
    {
        $this->user = $user;
        $this->snippet = $snippet;
    }

    /**
     * Show listing of users
     * GET /profiles
     */
    public function getIndex()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 10;

        $pagiData = $this->user->byPage($page, $perPage);
        $users = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        return View::make('users.index', compact('users'));
    }

    /**
     * Show profile of a user
     * GET /profiles/{slug}
     */
    public function getProfile($slug)
    {
        $user = $this->user->bySlug($slug);

        if (! $user) {
            return App::abort(404);
        }

        return View::make('users.profile', compact('user'));
    }

    /**
     * Show listing of snippets of a user
     * GET /profiles/{slug}/snippets
     */
    public function getSnippets($slug)
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 10;

        $pagiData = $this->snippet->byAuthor($slug, $page, $perPage);
        $user = $pagiData->user;
        $snippets = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        return View::make('users.snippets', compact('snippets', 'user'));
    }

}
