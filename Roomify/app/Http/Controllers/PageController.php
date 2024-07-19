<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function homeUser()
    {
        $hotels = Hotel::where('status', 'verified');
        return view('Users.home', compact('hotels'));
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function login()
    {
        return view('Auth.login');
    }

    // public function detailHotel($hotelId)
    // {
    //     return view('Users.detailHotel');
    // }

    public function homeOwner()
    {
        $user = Auth::user();
        $hotels = Hotel::where('user_id', $user->id)->with('location')->get();
        return view('Owner.home', compact('hotels'));
    }

    public function addHotel()
    {
        $locations = Location::orderBy('location_name', 'asc')->get();
        return view('Owner.addHotel', compact('locations'));
    }
    public function updateHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $locations = Location::orderBy('location_name', 'asc')->get();
        return view('Owner.updateHotel', compact('hotel', 'locations'));
    }

    public function homeAdmin()
    {
        $user = Auth::user();
        $hotels = Hotel::all();
        return view('Admin.home', compact('hotels'));
    }
}
