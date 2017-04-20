<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Apartment extends Model
{
    use Filterable, Sluggable, SluggableScopeHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'county_id', 'price', 'description', 'stars', 'active_until'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Use the slug database column for implicit model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the user that owns the apartment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the availability of the apartment.
     */
    public function availability()
    {
        return $this->hasMany(ApartmentAvailability::class);
    }

    /**
     * Get the comments for the apartment.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the county that the apartment is located in.
     */
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    /**
     * Get the images of the apartment.
     */
    public function images()
    {
        return $this->hasMany(ApartmentImage::class);
    }

    /**
     * Get the ratings of the apartment.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Scope the query to records created this year.
     *
     * @param  Builder $query
     * @return mixed
     */
    public function scopeThisYear($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->firstOfYear());
    }

    /**
     * Filter a result set.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active_until', '>=', Carbon::now());
    }
}
