<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\County;
use App\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
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
     * Shows users index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Creating datatables for admin with users
     *
     * @return mixed
     */
    public function showDatatables(){
        $users = User::with('role')->get();

        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '<a href="'.route("admin.users.user", $users->slug).'" class="btn btn-xs btn-primary"> Prikaži </a>';
            })
            ->make(true);
    }

    /**
     * Creating datatables for admin with users apartments ads
     *
     * @return mixed
     */
    public function showDatatablesApartments($slug, $type){
        $user = User::with('apartments')->where('slug', '=', $slug)->first();
        $apartments = $user->apartments->where('validation', '=', $type);

        return Datatables::of($apartments)
            ->addColumn('action', function ($apartments) use ($user) {
                return '<a href="'.route("admin.users.user.apartment", [$user->slug, $apartments->slug]).'" class="btn btn-xs btn-primary"> Prikaži </a>';
            })
            ->make(true);
    }


    /**
     * Show users page for editing
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $user = User::where('slug', '=', $slug)->first();
        return view('admin.users-user', ['user' => $user ]);
    }

    /**
     * Updates users email and role
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $slug)
    {
        $user = User::where('slug', '=', $slug)->first();

        $user->role_id = $request->role;
        $user->email = $request->email;

        $user->save();

        return redirect(route('admin.users.index'));
    }

    /**
     * Shows form for editing users ads
     *
     * @param null $slugUser
     * @param null $slugApartment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($slugUser = null, $slugApartment = null)
    {
        $apartment = Apartment::where('slug', '=', $slugApartment)->first();
        $counties = County::all();

        return view('admin.users-user-apartment', ['apartment' => $apartment, 'counties' =>  $counties]);
    }

    /**
     * Updates users ad in database
     *
     * @param Request $request
     * @param $slugUser
     * @param $slugApartment
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateApartment(Request $request, $slugUser, $slugApartment)
    {
        $apartment = Apartment::where('slug', '=', $slugApartment)->first();

        if ($request->button == "update") {
            $apartment->price = $request->price;
            //$apartment->currency = $request->currency;
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
