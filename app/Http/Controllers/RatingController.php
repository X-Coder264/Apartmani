<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store the rating in the DB.
     *
     * @param  Request $request
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Apartment $apartment)
    {
        $user = Auth::user();
        $rating = Rating::where('user_id', '=', $user->id)->where('apartment_id', '=', $apartment->id)->first();
        if (! $rating) {
            $rating = new Rating();
            $rating->rating = $request->input('rating');
            $rating->user_id = $user->id;
            $rating->apartment_id = $apartment->id;
            $rating->save();
        } else {
            $rating->rating = $request->input('rating');
            $rating->save();
            return back()->with('success', "The rating is successfully changed.");
        }

        return back()->with('success', "The rating is successfully submitted.");
    }
}
