<?php namespace Member;

use BaseController;
use View;
use Input;
use Redirect;
use Paginator;
use Auth;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;
use LaraSnipp\Service\Form\Snippet\SnippetForm;

class UserController extends BaseController {

    /**
     * Snippet repository
     *
     * @var \LaraSnipp\Repo\Snippet\SnippetRepositoryInterface
     */
    protected $snippet;

    public function __construct(SnippetRepositoryInterface $snippet)
    {
        $this->snippet = $snippet;
    }

    /**
     * Show snippet listing of the current logged-in user
     * GET /members/my-snippets
     */
    public function getMySnippets()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 10;

        $pagiData = $this->snippet->byAuthor(Auth::user()->slug, $page, $perPage, $all = true);
        $snippets = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);
        return View::make('member.users.snippets', compact('snippets'));
    }

}