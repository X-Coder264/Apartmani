<?php

namespace App\Http\Controllers;

use App\User;
use App\County;
use App\Apartment;
use App\Mail\ApproveAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.home');
    }

    public function getModeratorData()
    {
        $apartments = Apartment::select(['id', 'name', 'user_id', 'county_id', 'description', 'premium', 'created_at', 'updated_at', 'slug']) -> where('validation', '=', '0');

        return Datatables::of($apartments)
            ->addColumn('action', function ($apartments) {
                return '<a href="admin/'.$apartments->slug.'" class="btn btn-xs btn-primary"> Provjeri </a>';
            })
            ->make(true);
    }

    public function showApartment($slug)
    {
        $apartment = Apartment::where('slug', '=', $slug)->first();
        return view('admin.apartment', ['apartment' => $apartment ]);
    }

    public function getApartmentResponse(Request $request, $slug)
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

        return redirect('/admin')->with('success', 'Oglas je validiran!');

    }

    public function getUsers()
    {
        return view('admin.users');
    }

    public function getUsersData()
    {
        $users = User::with('role')->get();

        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '<a href="users/'.$users->slug.'" class="btn btn-xs btn-primary"> Prikaži </a>';
            })
            ->make(true);
    }

    public function showUser($slug)
    {
        $user = User::where('slug', '=', $slug)->first();
        return view('admin.user-show', ['user' => $user ]);
    }

    public function updateUser(Request $request, $slug)
    {
        $user = User::where('slug', '=', $slug)->first();

        $user->role_id = $request->role;
        $user->email = $request->email;

        $user->save();

        return redirect('/admin/users');

    }

    public function getUsersActiveAds($slug, $type)
    {
        $user = User::with('apartments')->where('slug', '=', $slug)->first();
        $apartments = $user->apartments->where('validation', '=', $type);

        return Datatables::of($apartments)
            ->addColumn('action', function ($apartments) use ($user) {
                return '<a href="'.$user->slug.'/'.$apartments->slug.'/edit" class="btn btn-xs btn-primary"> Prikaži </a>';
            })
            ->make(true);
    }

    public function showUsersApartment($slugUser, $slugApartment)
    {
        $apartment = Apartment::where('slug', '=', $slugApartment)->first();
        $counties = County::all();

        return view('admin.apartment-moderator-edit', ['apartment' => $apartment, 'counties' =>  $counties]);
    }

    public function editUsersApartment(Request $request, $slugUser, $slugApartment)
    {
        $apartment = Apartment::where('slug', '=', $slugApartment)->first();

        if ($request->button == "update") {
            $apartment->price = $request->price;
            $apartment->currency = $request->currency;
            $apartment->description = $request->description;
            $apartment->county_id = $request->county_id;
            $apartment->stars = $request->stars;
            $apartment->save();
        } else if ($request->button == "delete") {
            $apartment->delete();
        } else if ($request->button == "block") {
            $apartment->validation = -1;
            $apartment->save();
        }

        return redirect(route('admin.users.user', $slugUser));
    }
}
