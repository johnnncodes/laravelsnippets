<?php namespace LaraSnipp\Repo\Tag;

use LaraSnipp\Repo\EloquentBaseRepository;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepositoryInterface
{
    protected $tag;

    // Class expects an Eloquent model
    public function __construct(Model $tag)
    {
        parent::__construct($tag);
        $this->tag = $tag;
    }

}
