<?php namespace Member;

use BaseController;
use View;
use Input;
use Redirect;
use Auth;
use App;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;
use LaraSnipp\Service\Form\Snippet\SnippetForm;

class SnippetController extends BaseController
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
     * Tag repository
     *
     * @var \LaraSnipp\Repo\Snippet\UserRepositoryInterface
     */
    protected $tag;

    /**
     * Snippet form
     *
     * @var LaraSnipp\Service\Form\Snippet\SnippetForm
     */
    protected $snippetForm;

    public function __construct(
        SnippetRepositoryInterface $snippet,
        UserRepositoryInterface $user,
        TagRepositoryInterface $tag,
        SnippetForm $snippetForm)
    {
        $this->snippet = $snippet;
        $this->user = $user;
        $this->tag = $tag;
        $this->snippetForm = $snippetForm;
    }

    /**
     * Show a single snippet of a user
     * GET /members/snippets/{slug}
     *
     * @param string $slug Slug of a snippet
     */
    public function getShow($slug)
    {
        $snippet = $this->snippet->bySlug($slug, $all = true);

        if (!$snippet) {
            return App::abort(404);
        }

        $user = Auth::user();
        $has_starred = !empty($user) ? $user->hasStarred($snippet->id) : false;

        $tags = $this->tag->all();
        $topSnippetContributors = $this->user->getTopSnippetContributors();

        return View::make('snippets.show', compact('snippet', 'has_starred', 'tags', 'topSnippetContributors'));
    }

    /**
     * Show the snippet create form
     * GET /members/submit/snippet
     */
    public function getCreate()
    {
        $tags = $this->tag->all()->lists('name', 'id');

        return View::make('member.snippets.create', compact('tags'));
    }

    /**
     * Process snippet submission
     * POST /members/submit/snippet
     */
    public function postStore()
    {
        if ($this->snippetForm->create(Input::all())) {
            return Redirect::route('member.snippet.getCreate')
                ->with('message', "Your snippet is now submitted and waiting for admin's approval")
                ->with('messageType', "success");
        }

        return Redirect::route('member.snippet.getCreate')
            ->withInput()
            ->withErrors($this->snippetForm->errors());
    }

    /**
     * Show the snippet edit form
     * GET /members/snippets/{slug}/edit
     */
    public function getEdit($slug)
    {
        $snippet = $this->snippet->bySlug($slug, $all = true);

        // validate that the user updating the snippet is the snippet author
        if (!$snippet->isTheAuthor(Auth::user())) return App::abort(404);

        $tags = $this->tag->all()->lists('name', 'id');

        return View::make('member.snippets.edit', compact('snippet', 'tags'));
    }

    /**
     * Process edit snippet form
     * POST /members/snippets/{slug}/update
     */
    public function postUpdate($slug)
    {
        if ($snippet = $this->snippetForm->update($slug, Input::all())) {
            return Redirect::route('member.snippet.getShow', $snippet->slug)
                ->with('message', 'Update successful')
                ->with('messageType', 'success');
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->snippetForm->errors());
    }
}
