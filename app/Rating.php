<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rating extends Model
{
    /**
     * Set the keys for a save update query.
     * This method had to be overridden because this model's table has a composite primary key.
     *
     * @param  Builder $query
     * @return Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('user_id', '=', $this->user_id)
              ->where('apartment_id', '=', $this->apartment_id);

        return $query;
    }

    /**
     * Get the apartment of this rating.
     */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * Get the user who gave this rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
