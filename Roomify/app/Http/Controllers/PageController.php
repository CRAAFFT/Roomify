<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
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
        $hotels = Hotel::where('user_id', $user->id)->get();
        return view('Owner.home', compact('hotels'));
    }

    public function addHotel()
    {
        return view('Owner.addHotel');
    }

    public function homeAdmin()
    {
        $user = Auth::user();
        $hotels = Hotel::all();
        return view('Admin.home', compact('hotels'));
    }
}
