<?php

namespace App\Http\Controllers;

use App\County;
use App\Apartment;
use App\ApartmentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotWritableException;

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
        // TODO: add validation

        $data = $request->except('images');
        $apartment = Auth::user()->apartments()->create($data);

        $images = collect($request->file('images'));
        $images->each(function ($item, $key) use (&$apartment) {
            $name = $item->getClientOriginalName();

            $image_file = Image::make($item);
            $path = public_path() . '/apartment_images/' . $apartment->slug . '/';
            File::makeDirectory($path, $mode = 0775, true, true);

            try {
                $image_file->save($path . $name);
            } catch (NotWritableException $e) {
                $apartment->delete();
                return back()->with(['error' => "Dogodila se greška. Molimo pokušajte kasnije."]);
            }

            if ($key == 0) {
                $apartment->main_image = $name;
                $apartment->save();
            } else {
                $image = new ApartmentImage();
                $image->apartment_id = $apartment->id;
                $image->path = $name;
                $image->save();
            }
        });

        return back()->with('success', "The apartment is successfully submitted.");
    }

    /**
     * Show the apartment.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $apartment->load('user', 'comments.user', 'ratings');
        $number_of_ratings = $apartment->ratings->count();
        $current_user_rated = false;
        if ($number_of_ratings > 0) {
            $average_rating = $apartment->ratings->avg('rating');
            $user_rating = 0;

            if (Auth::check()) {
                $user_id = Auth::user()->id;

                foreach ($apartment->ratings as $rating) {
                    if ($rating->user_id === $user_id) {
                        $current_user_rated = true;
                        $user_rating = $rating->rating;
                    }
                }
            }
            return view('apartments.show',
                compact('apartment', 'number_of_ratings', 'average_rating', 'current_user_rated', 'user_rating'));
        }

        return view('apartments.show', compact('apartment', 'number_of_ratings', 'current_user_rated'));
    }

    /**
     * Show the apartment edit form.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $counties = County::all();

        return view('apartments.edit', compact('apartment','counties'));
    }

    /**
     * Update the apartment.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        // TODO: add validation
        $apartment->price = $request->price;
        $apartment->description = $request->description;
        $apartment->county_id = $request->county_id;
        $apartment->stars = $request->stars;
        $apartment->save();
        return back()->with('success', "Promjene su uspješno spremljene.");
    }
}
