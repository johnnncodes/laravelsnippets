<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The fields who are mass assignable
     *
     * @var string
     */
    protected $fillable = array(
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'twitter_url',
        'github_url',
        'facebook_url',
        'website_url',
        'about_me'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Config for eloquent sluggable package
     * Reference: https://github.com/cviebrock/eloquent-sluggable
     *
     * @var array
     */
    public static $sluggable = array(
        'build_from' => 'full_name',
        'save_to' => 'slug',
    );

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function snippets()
    {
        return $this->hasMany('Snippet', 'author_id');
    }

    /**
     * A user has a role, like administration etc.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('Role');
    }

    /**
     * The user has starred snippets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function starred()
    {
        return $this->hasMany('Starred');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Full name eloquent accessor
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Returns the absolute url for the profile picture
     * @return string
     */
    public function getAbsPhotoUrlAttribute()
    {
        if (!$this->photo_url) {

            $hash = md5(trim(strtolower($this->attributes["email"])));

            return "http://www.gravatar.com/avatar/" . $hash . "?s=120";
        }

        $assetsDir = asset('/');

        return $assetsDir . $this->photo_url;
    }

    /**
     * Gets the number of snippets that a user has
     * @return mixed
     */
    public function getSnippetsCountAttribute()
    {
        return $this->snippets()->where('approved', 1)->count();
    }

    /**
     * Password eloquent mutator
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Checks if user is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active ? true : false;
    }

    /**
     * Activates a user
     *
     * @param $key
     * @throws RuntimeException
     * @return boolean
     */
    public function activate($key)
    {
        if ($this->activation_key === $key) {

            $this->active = 1;

            if ($this->save()) {
                return true;
            }

            throw new \RuntimeException('Saving to database failed.');
        }

        return false;
    }

    /**
     * Checks if user is administration
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Checks if a user has starred a snippet
     *
     * @param  integer $snippet_id
     * @return bool
     */
    public function hasStarred($snippet_id)
    {
        return $this->starred()->whereSnippetId($snippet_id)->count() ? true : false;
    }

    /**
     * Stars a snippet
     *
     * @param  integer $snippet_id
     * @return bool
     */
    public function starSnippet($snippet_id)
    {
        if ($this->hasStarred($snippet_id)) {
            return;
        }

        $this->starred()->create(array('snippet_id' => $snippet_id));
    }

    /**
     * Unstars a snippet
     *
     * @param  integer $snippet_id
     * @return bool
     */
    public function unstarSnippet($snippet_id)
    {
        if (!$this->hasStarred($snippet_id)) {
            return;
        }

        $this->starred()->whereSnippetId($snippet_id)->delete();
    }

}
