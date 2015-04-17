<?php namespace LaraSnipp\Repo\Snippet;

interface SnippetRepositoryInterface
{
    /**
     * Get paginated snippets
     *
     * @param $perPage
     * @param  boolean $all Show published or all
     * @param $q
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($perPage = 30, $all = false, $q = null);

    /**
     * Get snippets by their tag
     *
     * @param string  URL slug of tag
     * @param int $page
     * @param int $limit
     * @internal param Number $int of snippets per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($slug, $page = 1, $limit = 10);

    /**
     * Get snippets ordered by their number of views/hits
     *
     * @param int|string $limit Number of maximum snippets to return
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMostViewed($limit = 5);

    /**
     * Get snippets by their author
     *
     * @param  string $slug Slug of author
     * @param  int $page Page number
     * @param  int $limit Number of snippets per page
     * @param bool $all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byAuthor($slug, $page = 1, $limit = 10, $all = false);

    /**
     * Create a snippet
     *
     * @param  array $data Array of inputs
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update a snippet
     *
     * @param  Illuminate\Database\Eloquent\Model $snippet Snippet Model
     * @param array $input
     * @internal param array $data Array of inputs
     * @return boolean
     */
    public function update($snippet, array $input);

    /**
     * Get snippets by their slug
     *
     * @param  string $slug Slug of snippet
     * @param  boolean $all Wether to include not yet approved snippets
     * @return Illuminate\Database\Eloquent\Model
     */
    public function bySlug($slug, $all = false);
}
