<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class ApartmentFilters extends QueryFilters
{
    /**
     * Order by apartment creation date or price
     *
     * @param  int $order
     * @return Builder
     */
    public function orderBy($order = 0)
    {
        if ($order == 0) {
            return $this->builder->orderBy('created_at', 'desc');
        } elseif ($order == 1) {
            return $this->builder->orderBy('created_at', 'asc');
        } elseif ($order == 2) {
            return $this->builder->orderBy('price', 'desc');
        } else {
            return $this->builder->orderBy('price', 'asc');
        }
    }

    /**
     * Filter by starting price.
     *
     * @param  double $price
     * @return Builder
     */
    public function startPrice($price = 0.0)
    {
        return $this->builder->where('price', '>=', $price);
    }

    /**
     * Filter by ending price.
     *
     * @param  double $price
     * @return Builder
     */
    public function endPrice($price = 100000.0)
    {
        return $this->builder->where('price', '<=', $price);
    }

    /**
     * Filter by county.
     *
     * @param  string $county
     * @return Builder
     */
    public function county($county = 0)
    {
        if ($county != 0) {
            return $this->builder->where('county_id', $county);
        } else {
            return $this->builder;
        }
    }

    /**
     * Filter by stars.
     *
     * @param  int $stars
     * @return Builder
     */
    public function stars($stars = 0)
    {
        if ($stars != 0) {
            return $this->builder->where('stars', '=', $stars);
        } else {
            return $this->builder;
        }
    }
}