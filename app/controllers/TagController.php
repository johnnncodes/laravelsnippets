<?php

use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;

class TagController extends BaseController
{
    /**
     * Tag repository
     *
     * @var \LaraSnipp\Repo\Snippet\UserRepositoryInterface
     */
    protected $tag;

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

    public function __construct(
        TagRepositoryInterface $tag,
        SnippetRepositoryInterface $snippet,
        UserRepositoryInterface $user)
    {
        $this->tag = $tag;
        $this->snippet = $snippet;
        $this->user = $user;
    }

    /**
     * Show listing of snippets filtered by a tag
     * GET /tags/{slug}
     */
    public function getShow($slug)
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 30;

        $pagiData = $this->snippet->byTag($slug, $page, $perPage);

        if (!$pagiData->tag) {
            return App::abort(404);
        }

        $tag = $pagiData->tag;
        $snippets = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        $tags = $this->tag->all();
        $topSnippetContributors = $this->user->getTopSnippetContributors();

        return View::make('tags.snippets', compact('snippets', 'tag', 'tags', 'topSnippetContributors'));
    }
}
