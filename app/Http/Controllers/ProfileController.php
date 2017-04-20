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
                return '<a href="'.route("apartments.edit", $apartments->slug).'" class="btn btn-xs btn-primary"> Izmijeni ovaj oglas </a>';
            })
            ->make(true);
    }
}
