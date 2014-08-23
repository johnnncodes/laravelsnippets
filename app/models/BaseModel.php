<?php

use Carbon\Carbon;

class BaseModel extends Eloquent
{
    
    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getHumanUpdatedAtAttribute()
    {
        return $this->udpated_at->diffForHumans();
    }

}
