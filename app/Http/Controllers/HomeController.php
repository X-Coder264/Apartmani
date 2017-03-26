<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\ApartmentFilters;
use App\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('home', compact('apartments', 'counties'));
    }
}
