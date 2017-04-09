<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'apartments_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'apartment_id',
    ];
}
