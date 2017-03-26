<?php

namespace App\Http\Controllers;

use App\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Show the apartment's creation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counties = County::all();

        return view('apartments.create', compact('counties'));
    }

    /**
     * Store the apartment in the DB.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->apartments()->create($request->all());

        return back()->with('success', "The apartment is successfully submitted.");
    }
}
