<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MongoLogError extends Model {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'logs';

    protected $fillable = [
        'env',
        'formatted',
        'level',
        'context',
        'extra'
    ];

    protected $casts = [
        'context' => 'array',
        'extra'   => 'array'
    ];
}