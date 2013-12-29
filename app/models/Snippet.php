<?php

class Snippet extends BaseModel {

    protected $fillable = array(
        'title',
        'body',
        'description',
        'credits_to',
        'resource'
    );

    protected $softDelete = true;

    /**
     * Config for eloquent sluggable package
     * Reference: https://github.com/cviebrock/eloquent-sluggable
     *
     * @var array
     */
    public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    public function author()
    {
        return $this->belongsTo('User');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

    /**
     * Hits eloquent accessor
     *
     * @return string
     */
    public function getHitsAttribute()
    {
        $redis = App::make('redis');
        return $redis->zScore('hits', $this->id);
    }

    /**
     * Determine if Snippet has hits/views
     *
     * @return boolean
     */
    public function hasHits()
    {
        return $this->hits ? true : false;
    }

    /**
     * Determine if the passed User is the Snippet author
     *
     * @param User $user User instance
     * @return boolean
     */
    public function isTheAuthor($user)
    {
        return $this->author_id === $user->id ? true : false;
    }

    /**
     * Increment hits count
     */
    public function incrementHits()
    {
        $redis = App::make('redis');
        $redis->zIncrBy('hits', 1, $this->id);
    }

}