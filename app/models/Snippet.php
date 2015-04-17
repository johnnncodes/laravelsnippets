<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Snippet extends BaseModel
{
    /**
     * The fields who are mass assignable
     *
     * @var $fillable typeof array
     */
    protected $fillable = array(
        'title',
        'body',
        'description',
        'credits_to',
        'resource'
    );

    /**
     * Soft deleting
     *
     * @var $dates typeof array
     */
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    /**
     * Config for eloquent sluggable package
     * Reference: https://github.com/cviebrock/eloquent-sluggable
     *
     * @var array
     */
    public static $sluggable = array(
        'build_from' => 'title',
        'save_to' => 'slug',
    );

    /**
     * The snippet belongs to a user
     *
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo('User');
    }

    /**
     * The snippet has many tags
     *
     * @return mixed
     */
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
     * @param  User $user User instance
     * @return boolean
     */
    public function isTheAuthor($user)
    {
        return $this->author_id === $user->id;
    }

    /**
     * Increment hits count
     */
    public function incrementHits()
    {
        $redis = App::make('redis');
        $redis->zIncrBy('hits', 1, $this->id);
    }

    /**
     * Tests links for twitter/url
     */
    protected function testLink($url)
    {
        stream_context_set_default(
            [
                "http" => [
                    "method" => "HEAD"
                ]
            ]
        );

        try {
            $headers = get_headers($url);
        } catch (Exception $e) {
            return false;
        }

        foreach ($headers as $header) {
            if (stristr($header, "200 OK")) {
                return $url;
            }
        }

        return false;
    }

    /**
     * Gets links for twitter/url
     */
    public function getCreditsToLinkAttribute()
    {
        $creditsTo = $this->attributes["credits_to"];
        $twitterHandle = str_replace("@", "", $creditsTo);

        $twitterLink = Cache::remember("credits_to_link_twitter_" . $creditsTo, 60, function () use ($twitterHandle) {
            $url = "http://twitter.com/" . $twitterHandle;

            return $this->testLink($url);
        });

        if ($twitterLink) {
            return $twitterLink;
        }

        $normalLink = Cache::remember("credits_to_link_normal_" . $creditsTo, 60, function () use ($creditsTo) {
            return $this->testLink($creditsTo);
        });

        if ($normalLink) {
            return $normalLink;
        }

        return null;
    }

    /**
     * A snippet can be starred by users
     *
     * @return mixed
     */
    public function starred()
    {
        return $this->hasMany('Starred');
    }


    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

}
