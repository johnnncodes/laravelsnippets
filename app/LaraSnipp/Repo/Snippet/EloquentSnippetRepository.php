<?php namespace LaraSnipp\Repo\Snippet;

use App;
use DB;
use LaraSnipp\Repo\EloquentBaseRepository;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentSnippetRepository extends EloquentBaseRepository implements SnippetRepositoryInterface
{
    /**
     * Snippet Model
     *
     * @var $snippet typeof \Illuminate\Database\Eloquent\Model
     */
    protected $snippet;

    /**
     * Tag repository
     *
     * @var $tag typeof \LaraSnipp\Repo\Tag\TagRepositoryInterface
     */
    protected $tag;

    /**
     * User repository
     *
     * @var $user typeof \LaraSnipp\Repo\User\UserRepositoryInterface
     */
    protected $user;

    public function __construct(
        Model $snippet,
        TagRepositoryInterface $tag,
        UserRepositoryInterface $user)
    {
        parent::__construct($snippet);
        $this->snippet = $snippet;
        $this->tag = $tag;
        $this->user = $user;
    }

    /**
     * Get paginated snippets
     *
     * @param int $perPage
     * @param  boolean $all Show published or all
     * @param $q
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($perPage = 30, $all = false, $q = null)
    {
        $query = $q ? $this->snippet->like('title', $q)->orderBy('created_at', 'desc')->with('Starred') : $this->snippet->orderBy('created_at', 'desc')->with('Starred');

        if (!$all) {
            $query->where('approved', 1);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get total snippets count
     *
     * @todo I hate that this is public for the decorators.
     *       Perhaps interface it?
     * @param bool $all
     * @return int Total snippets
     */
    protected function totalSnippets($all = false)
    {
        if (!$all) {
            return $this->snippet->where('approved', 1)->count();
        }

        return $this->snippet->count();
    }

    /**
     * Get snippets by their tag
     *
     * @param $slug
     * @param int $page
     * @param int $limit
     * @internal param \LaraSnipp\Repo\Snippet\URL $string slug of tag
     * @internal param Number $int of snippets per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($slug, $page = 1, $limit = 10)
    {
        $tag = $this->tag->bySlug($slug);

        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();
        $result->tag = '';

        if (!$tag) {
            return $result;
        }

        $snippets = $tag->snippets()
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->totalByTag($slug);
        $result->items = $snippets->all();

        // attach tag in the result object so we can use it when needed
        $result->tag = $tag;

        return $result;
    }

    /**
     * Get total snippets count per tag
     *
     * @todo I hate that this is public for the decorators
     *       Perhaps interface it?
     * @param $slug
     * @internal param string $tag Tag slug
     * @return int    Total snippets per tag
     */
    protected function totalByTag($slug)
    {
        return $this->tag->bySlug($slug)
            ->snippets()
            ->where('approved', 1)
            ->count();
    }

    /**
     * Get snippets ordered by their number of views/hits
     *
     * @param int|string $limit Number of maximum snippets to return
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMostViewed($limit = 5)
    {
        $redis = App::make('redis');
        $mostViewedSnippets = $redis->zRevRange('hits', 0, $limit, array('withscores' => true));
        $snippetIds = array();

        // if there are no recorded hits in redis
        // lets return a blank eloquent collection
        if (empty($mostViewedSnippets)) {
            return new \Illuminate\Database\Eloquent\Collection;
        }

        foreach ($mostViewedSnippets as $snippet) {
            array_push($snippetIds, $snippet[0]);
        }

        $ids = implode(',', $snippetIds);

        // get all snippets at once and ordered by the current order
        // of ids inside $snippetIds array
        //
        // NOTE: here is the format
        //
        // Raw SQL:
        // SELECT * FROM snippets WHERE id IN (1,2) ORDER BY FIELD(id,2,1);
        //
        // Eloquent + raw query
        // $snippets = static::whereIn('id', $snippetIds)
        //     ->orderByRaw(DB::raw("FIELD(id, 2,1)"))
        //     ->get();
        $snippets = $this->snippet->whereIn('id', $snippetIds)
            ->orderByRaw(DB::raw("FIELD(id, $ids)"))
            ->take($limit)
            ->get();

        return $snippets;
    }

    /**
     * Get snippets by their author
     *
     * @param  string $slug Slug of author
     * @param  int $page Page number
     * @param  int $limit Number of snippets per page
     * @param bool $all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byAuthor($slug, $page = 1, $limit = 10, $all = false)
    {
        $user = $this->user->bySlug($slug);

        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if (!$user) {
            return $result;
        }

        $query = $user->snippets()
            ->orderBy('created_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit);

        if (!$all) {
            $query->where('approved', 1);
        }

        $snippets = $query->get();

        $result->totalItems = $this->totalByAuthor($slug);
        $result->items = $snippets->all();

        // attach user in the result object so we can use it when needed
        $result->user = $user;

        return $result;
    }

    /**
     * Get total snippets count per author
     *
     * @todo I hate that this is public for the decorators
     *       Perhaps interface it?
     * @param  string $slug Author slug
     * @return int    Total snippets per author
     */
    protected function totalByAuthor($slug)
    {
        return $this->user->bySlug($slug)
            ->snippets()
            ->where('approved', 1)
            ->count();
    }

    /**
     * Create a snippet
     *
     * @param  array $data Array of inputs
     * @return boolean
     */
    public function create(array $data)
    {
        if ($snippet = $this->snippet->create($data)) {
            if (isset($data['tags'])) {
                $snippet->tags()->sync($data['tags']);
            } else {
                $snippet->tags()->detach();
            }

            return true;
        }

        return false;
    }

    /**
     * Update a snippet
     *
     * @param  Illuminate\Database\Eloquent\Model $snippet Snippet Model
     * @param array $input
     * @internal param array $data Array of inputs
     * @return boolean
     */
    public function update($snippet, array $input)
    {
        $snippet->fill($input);

        if ($snippet->save()) {
            if (isset($input['tags'])) {
                $snippet->tags()->sync($input['tags']);
            } else {
                $snippet->tags()->detach();
            }

            return true;
        }

        return false;
    }

    /**
     * Get snippets by their slug
     *
     * @param  string $slug Slug of snippet
     * @param  boolean $all Wether to include not yet approved snippets
     * @return Illuminate\Database\Eloquent\Model
     */
    public function bySlug($slug, $all = false)
    {
        $query = $this->model->whereSlug($slug);

        if (!$all) {
            $query->where('approved', 1);
        }

        return $query->first();
    }
}
