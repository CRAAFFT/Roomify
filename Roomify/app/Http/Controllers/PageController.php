<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Location;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function homeUser()
    {
        $hotels = Hotel::where('status', 'verified')->with('location')->get();
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

    public function detailHotel($hotel_id)
    {
        $user = Auth::user();
        $hotel = Hotel::find($hotel_id);
        if ($user->role == 'owner') 
        {
            $rooms = Room::where('hotel_id', $hotel_id)->with('hotel')->get();
            return view('Owner.detailHotel', compact('rooms', 'hotel'));
        } 
        else if ($user->role == 'admin') 
        {
            return view('Admin.detailHotel', compact('hotel'));
        }
        else
        {
            return view('Users.detailHotel', compact('hotel'));
        }
    }

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

    public function addRoom($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        return view('Owner.addRoom', compact('hotel'));
    }

    public function homeAdmin()
    {
        $user = Auth::user();
        $hotels = Hotel::all();
        return view('Admin.home', compact('hotels'));
    }
}
