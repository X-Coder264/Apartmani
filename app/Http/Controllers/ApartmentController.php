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

            if($key == 0) {
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
     * @param  Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $apartment->load('user', 'comments.user');
        return view('apartments.show', ['apartment' => $apartment]);
    }
}
