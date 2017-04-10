<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder $query
     * @param  QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Collection | \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}