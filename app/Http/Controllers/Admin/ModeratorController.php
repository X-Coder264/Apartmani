<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\Mail\ApproveAd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ModeratorController extends Controller
{


    /**
     * Checks if user is authorized to access
     *
     * ModeratorController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a moderator index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.moderator');
    }

    /**
     * Creating datatables for moderator with apartments
     *
     * @return mixed
     */
    public function showDatatables()
    {
        $apartments = Apartment::select(['id', 'name', 'user_id', 'county_id', 'description', 'premium', 'created_at', 'updated_at', 'slug']) -> where('validation', '=', '0');

        return Datatables::of($apartments)
            ->addColumn('action', function ($apartments) {
                return '<a href="'.route("admin.moderator.apartment", $apartments->slug).'" class="btn btn-xs btn-primary"> Provjeri </a>';
            })
            ->make(true);
    }


    /**
     * Shows apartment ad for verification
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //Log::info('POkazuje Aprtman.', ['apartment' => $slug]);

        $apartment = Apartment::where('slug', '=', $slug)->first();
        return view('admin.moderator-apartment', ['apartment' => $apartment ]);
    }


    /**
     * Updates apartments validation value in database, depending if it passed validation or not.
     * Sends users e-mail about validation results.
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        $apartment = Apartment::where('slug', '=', $slug)->first();

        if ($request->button == "Dozvoli") {
            $apartment->validation = '1';
            $apartment->save();

            Mail::to($apartment->user->email)->send(new ApproveAd($apartment->user, "Vaš oglas je prošao validaciju."));
        } else {
            $apartment->validation = '-1';
            $apartment->save();
            Mail::to($apartment->user->email)->send(new ApproveAd($apartment->user, $request->message));
        }

        return redirect(route('admin.moderator.index'))->with('success', 'Oglas je validiran!');
    }

}
