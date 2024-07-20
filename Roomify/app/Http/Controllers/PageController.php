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
        $rooms = Room::where('hotel_id', $hotel_id)->get();
        return view('detailHotel', compact('rooms', 'hotel'));
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
        return view('Manage.addHotel', compact('locations'));
    }

    public function updateHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $locations = Location::orderBy('location_name', 'asc')->get();
        return view('Manage.updateHotel', compact('hotel', 'locations'));
    }

    public function addRoom($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        return view('Manage.addRoom', compact('hotel'));
    }

    public function updateRoom($room_id)
    {
        $room = Room::find($room_id)->with('hotel')->first();
        return view('Manage.updateRoom', compact('room'));
    }

    public function homeAdmin()
    {
        $user = Auth::user();
        $hotels = Hotel::with('location')->get();
        return view('Admin.home', compact('hotels'));
    }

    public function addLocation()
    {
        $locations = Location::orderBy('location_name', 'asc')->get();
        return view('Admin.addLocation', compact('locations'));
    }
}
