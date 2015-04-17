<?php
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;

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

    /**
     * Tag repository
     *
     * @var \LaraSnipp\Repo\Snippet\TagRepositoryInterface
     */
    protected $tag;

    public function __construct(
        SnippetRepositoryInterface $snippet,
        UserRepositoryInterface $user,
        TagRepositoryInterface $tag)
    {
        $this->snippet = $snippet;
        $this->user = $user;
        $this->tag = $tag;
    }

    /**
     * Show home page
     * GET /
     */
    public function getIndex()
    {
        $perPage = Config::get('site.snippetsPerPage');

        $snippets = $this->snippet->byPage($perPage);
        $topSnippetContributors = $this->user->getTopSnippetContributors();
        $mostViewedSnippets = $this->snippet->getMostViewed(10);
        $tags = $this->tag->all();

        return View::make('website.pages.index', compact('snippets', 'topSnippetContributors', 'mostViewedSnippets', 'tags'));
    }

}
