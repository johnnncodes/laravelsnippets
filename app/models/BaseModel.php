<?php

use Carbon\Carbon;

class BaseModel extends Eloquent
{
    /**
     * Converts a timestamp in a more "human" way
     *
     * @param $column
     * @return null|string
     */
    protected function getHumanTimestampAttribute($column)
    {
        if ($this->attributes[$column]) {
            return Carbon::parse($this->attributes[$column])->diffForHumans();
        }

        return null;
    }

    /**
     * Converts a value of "created_at" column in a humanly readable way
     *
     * @return null|string
     */
    public function getHumanCreatedAtAttribute()
    {
        return $this->getHumanTimestampAttribute("created_at");
    }

    /**
     * Converts a value of "updated_at" column in a humanly readable way
     *
     * @return null|string
     */
    public function getHumanUpdatedAtAttribute()
    {
        return $this->getHumanTimestampAttribute("updated_at");
    }

}
