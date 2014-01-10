<?php namespace LaraSnipp\Composer;

use LaraSnipp\Repo\Tag\TagRepositoryInterface;

class LayoutMasterComposer
{
    protected $tag;

    public function __construct(TagRepositoryInterface $tag)
    {
        $this->tag = $tag;
    }

    public function compose($view)
    {
        $view->with('tags', $this->tag->all());
    }

}
