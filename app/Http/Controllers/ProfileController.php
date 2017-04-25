<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Show the user edit form.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('profile-edit', compact('user'));
    }

    /**
     * Update the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(Auth::user()->id === $user->id || Auth::user()->role->role == "Admin") {
            // TODO: add validation
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            return back()->with('success', "Promjene su uspješno spremljene.");
        } else {
            return back()->with('error', "Nemate prava za izmjeniti ovaj profil.");
        }
    }

    public function showApartmentsDatatable(User $user, $type){
        $user->load('apartments');
        if($type == 1) {
            $apartments = $user->apartments->where('validation', '=', $type)->where('active_until', '>=', Carbon::now());
        } elseif ($type == 2) {
            $apartments = $user->apartments->where('validation', '=', $type)->where('active_until', '<', Carbon::now());
        } else {
            $apartments = $user->apartments->where('validation', '=', $type);
        }

        return Datatables::of($apartments)
            ->addColumn('action', function ($apartments) use ($user) {
                $action = '<div class="btn-group">';
                $action .= '<a href="'.route("apartments.edit", $apartments->slug).'" class="btn btn-primary"> Izmijeni ovaj oglas </a>';
                $action .= '<form action="'.route("apartments.destroy", $apartments->slug).'" method="POST">' . csrf_field() . '<input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" name="button" value="delete">Obriši ovaj oglas</button></form>';
                $action .= '</div>';
                return $action;
            })
            ->make(true);
    }
}
