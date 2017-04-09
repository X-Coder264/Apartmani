<?php

namespace App\Http\Controllers;

use App\County;
use App\Apartment;
use App\ApartmentFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  ApartmentFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(ApartmentFilters $filters)
    {
        if(empty($filters->filters())) {
            $apartments = Apartment::orderBy('created_at', 'desc')->paginate(12);
        } else {
            $apartments = Apartment::filter($filters);
        }

        $counties = County::all();

        foreach($apartments as $apartment) {
            if (Cache::has('apartment.' . $apartment->slug . '.EUR_price')) {
                $apartment->eur_price = Cache::get('apartment.' . $apartment->slug . '.EUR_price');
            } else {
                $apartment->eur_price = round($apartment->price * get_EUR_exchange_rate(), 2);
                Cache::put('apartment.' . $apartment->slug . '.EUR_price', $apartment->eur_price, 24 * 60);
            }
        }

        return view('home', compact('apartments', 'counties'));
    }
}
