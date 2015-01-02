<?php

class Starred extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var $table typeof string
     */
    protected $table = 'user_starred';

    /**
     * Being a pivot table, we disable the timestamps (created_at and updated_at)
     *
     * @var $timestamps typeof bool
     */
    public $timestamps = false;

    /**
     * Fillable fields
     *
     * @var $fillable typeof array
     */
    protected $fillable = array(
        'snippet_id',
        'user_id'
    );

    /**
     * A "Star" belongs to a Snippet relationship
     *
     * @return mixed
     */
    public function snippet()
    {
        return $this->belongsTo('Snippet');
    }

}
