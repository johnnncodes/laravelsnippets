<?php namespace LaraSnipp\Repo\User;

use DB;
use LaraSnipp\Repo\EloquentBaseRepository;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    /**
     * User Eloquent Model
     *
     * @var $user typeof \Illuminate\Database\Eloquent\Model
     */
    protected $user;

    public function __construct(Model $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    /**
     * Get top snippets contributors
     *
     * @param  int $limit Results per page
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTopSnippetContributors($limit = 5)
    {
        return $this->user->from('users AS u')
            ->join('snippets AS s', 'u.id', '=', 's.author_id', 'LEFT OUTER')
            ->where('u.active', '=', 1)
            ->where('s.approved', '=', 1)
            ->whereRaw('s.deleted_at IS NULL')
            ->groupBy('s.author_id')
            ->orderBy('snippets_count', 'DESC')
            ->take($limit)
            ->get(array('u.id', 'u.first_name', 'u.last_name', 'u.slug',
                DB::raw('count(s.author_id) AS snippets_count')));
    }

    /**
     * Get paginated users
     *
     * @param  int      $page  Number of snippet per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show only active users or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, $all = false)
    {
        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->user->orderBy('created_at', 'desc');

        if (! $all) {
            $query->where('active', 1);
        }

        $users = $query->skip($limit * ($page-1))
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalUsers($all);
        $result->items = $users->all();

        return $result;
    }

    /**
     * Get total users count
     *
     * @todo I hate that this is public for the decorators.
     *       Perhaps interface it?
     * @param bool $all
     * @return int Total users
     */
    protected function totalUsers($all = false)
    {
        if (! $all) {
            return $this->user->where('active', 1)->count();
        }

        return $this->user->count();
    }
}
