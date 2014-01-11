<?php

class Tag extends Eloquent
{
    public $timestamps = false;

    public static $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public function snippets()
    {
        return $this->belongsToMany('Snippet');
    }

    /**
     * Determine if Tag has snippets
     *
     * @return boolean
     */
    public function hasSnippets()
    {
        return $this->snippets()->where('approved', 1)->count() ? true : false;
    }

}
