<?php

use Illuminate\Support\Facades\Redirect;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use LaraSnipp\Service\Form\User\UserForm;

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
    /**
     * @var UserForm
     */
    private $userForm;

    /**
     * @param UserRepositoryInterface $user
     * @param SnippetRepositoryInterface $snippet
     * @param UserForm $userForm
     */
    public function __construct(UserRepositoryInterface $user, SnippetRepositoryInterface $snippet, UserForm $userForm)
    {
        $this->user = $user;
        $this->snippet = $snippet;
        $this->userForm = $userForm;
    }

    /**
     * Show listing of users
     * GET /profiles
     */
    public function getIndex()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 12;

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

        if (!$user) {
            return App::abort(404);
        }

        return View::make('users.profile', compact('user'));
    }

    /**
     * Show listing of snippets of a user
     * GET /profiles/{slug}/snippets
     * @param $slug
     * @return
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

    /**
     * Show user's settings page
     * GET /profiles/{slug}/settings
     * @param $slug
     */
    public function getSettings($slug)
    {
        $user = Auth::user();
        return View::make('users.settings', compact('user'));
    }

    /**
     * Updates user settings
     * @param $slug
     * @return mixed
     */
    public function putSettings($slug)
    {
        $user = Auth::user();

        $result = $this->userForm->update($user, Input::all());

        if ($result) {
            return Redirect::route('user.getSettings', $slug)
                ->with('message', 'Successfully updated your settings.')
                ->with('messageType', "success");
        } else {
            return Redirect::route('user.getSettings', $slug)
                ->withInput()
                ->withErrors($this->userForm->errors());
        }
    }
}
