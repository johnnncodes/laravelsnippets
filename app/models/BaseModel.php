<?php

class BaseModel extends Eloquent
{

    /**
     * Get human created at date
     *
     * @return mixed
     */
    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get human updated at date
     *
     * @return mixed
     */
    public function getHumanUpdatedAtAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
