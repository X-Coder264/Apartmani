<?php

namespace App\Http\Controllers;

use App\ApartmentAvailability;
use App\County;
use App\Apartment;
use Carbon\Carbon;
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

        $dates = [];
        $x = 0;
        //Extracts from date range to dates
        foreach ($request->daterange as $daterange) {
            $dateStart = $dateEnd = "";
            for ($i = 0; $i < strlen($daterange); $i++) {
                $dateEnd .= $daterange[$i];
                if ($i == 9) {
                    $dateStart = $dateEnd;
                    $dateEnd = "";
                    $i = $i + 3;
                }
            }
            $dates[$x]["start_date"] = Carbon::createFromFormat('d.m.Y', $dateStart);
            $dates[$x++]["end_date"] = Carbon::createFromFormat('d.m.Y', $dateEnd);
        }

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

        foreach ($dates as $date) {
            $apartment->availability()->save(new ApartmentAvailability(['start_date' => $date["start_date"], 'end_date' => $date["end_date"]]));
        }

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
        $apartment->load('user', 'comments.user', 'ratings', 'availability');
        $number_of_ratings = $apartment->ratings->count();
        $current_user_rated = false;

        $dates = [];

        foreach ($apartment->availability as $availability) {
            for($date = $availability->start_date; $date->lte($availability->end_date); $date->addDay()) {
                $dates[] = $date->format('m/d/Y');
            }
        }

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
                compact('apartment', 'number_of_ratings', 'average_rating', 'current_user_rated', 'user_rating', 'dates'));
        }

        return view('apartments.show', compact('apartment', 'number_of_ratings', 'current_user_rated', 'dates'));
    }

    /**
     * Show the apartment edit form.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        if(Auth::user()->id === $apartment->user_id || Auth::user()->role->role == "Admin") {
            $counties = County::all();
            return view('apartments.edit', compact('apartment','counties'));
        } else {
            return back();
        }
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
        if(Auth::user()->id === $apartment->user_id || Auth::user()->role->role == "Admin") {
            // TODO: add validation
            $apartment->price = $request->price;
            $apartment->description = $request->description;
            $apartment->county_id = $request->county_id;
            $apartment->stars = $request->stars;
            $apartment->save();
            return back()->with('success', "Promjene su uspješno spremljene.");
        } else {
            return back()->with('error', "Nemate prava za izmjeniti ovaj oglas.");
        }
    }
}
