<?php

class Starred extends BaseModel
{
    protected $table = 'user_starred';

    public $timestamps = false;

    protected $fillable = array(
        'snippet_id',
        'user_id'
    );

    public function snippet()
    {
        return $this->belongsTo('Snippet');
    }

}
