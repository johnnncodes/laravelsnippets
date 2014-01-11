<?php

use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;

class HomeController extends BaseController
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

    public function __construct(SnippetRepositoryInterface $snippet, UserRepositoryInterface $user)
    {
        $this->snippet = $snippet;
        $this->user = $user;
    }

    /**
     * Show home page
     * GET /
     */
    public function getIndex()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 5;

        $pagiData = $this->snippet->byPage($page, $perPage);
        $data['snippets'] = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);
        $data['topSnippetContributors'] = $this->user->getTopSnippetContributors();
        $data['mostViewedSnippets'] = $this->snippet->getMostViewed();

        return View::make('home.index', $data);
    }

}
