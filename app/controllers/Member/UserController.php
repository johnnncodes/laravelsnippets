<?php namespace Member;

use BaseController;
use View;
use Input;
use Paginator;
use Auth;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;

class UserController extends BaseController
{
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
     * Show dashboard with snippets and starred snippets of the current logged-in user
     * GET /members/dashboard
     */
    public function dashboard()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 10;

        $pagiData = $this->snippet->byAuthor(Auth::user()->slug, $page, $perPage, $all = true);
        $my_snippets = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        $user = Auth::user();
        $starred_snippets = $user->starred()->with('Snippet')->get();

        return View::make('member.users.dashboard', compact('my_snippets', 'starred_snippets'));
    }
}
