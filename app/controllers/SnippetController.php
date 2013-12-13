<?php

use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;

class SnippetController extends BaseController {

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

    public function __construct(SnippetRepositoryInterface $snippet, UserRepositoryInterface $user)
    {
        $this->snippet = $snippet;
        $this->user = $user;
    }

    /**
     * Show listing of snippets
     * GET /snippets
     */
    public function getIndex()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 10;

        $pagiData = $this->snippet->byPage($page, $perPage);
        $snippets = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);
        return View::make('snippets.index', compact('snippets'));
    }

    /**
     * Show an individual snippet
     * GET /snippets/{slug}
     */
    public function getShow($slug)
    {
        $snippet = $this->snippet->bySlug($slug);

        if ( ! $snippet)
        {
            return App::abort(404);
        }

        # increment hit count
        $redis = App::make('redis');
        $redis->zIncrBy('hits', 1, $snippet->id);

        return View::make('snippets.show', compact('snippet'));
    }

}