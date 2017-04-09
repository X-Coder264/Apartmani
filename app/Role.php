<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role'
    ];

    /**
     * Get the users of the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
