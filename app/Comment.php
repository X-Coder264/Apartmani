<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get the user that owns the comments.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
