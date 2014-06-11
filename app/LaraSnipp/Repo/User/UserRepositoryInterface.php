<?php namespace LaraSnipp\Repo\User;

interface UserRepositoryInterface
{
    /**
     * Get top snippets contributors
     *
     * @param  int $limit Results per page
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTopSnippetContributors($limit = 5);

    /**
     * Get paginated users
     *
     * @param  int $page Number of snippet per page
     * @param  int $limit Results per page
     * @param  boolean $all Show only active users or all
     * @return \StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, $all = false);
}
