<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Validators;

class OwnerController extends Controller
{
    public function addHotel(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'file|required|mimes:png,jpg,jpeg|max:2048',
                'hotel_name' => 'required',
                'location' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store($request->hotel_name, 'public');
    
            $user = Auth::user();
            $hotel = Hotel::create([
                'hotel_name' => $request->hotel_name,
                'image' => $image,
                'location_id' => $request->location,
                'user_id' => $user->id,
            ]);
    
            return redirect()->route('homeOwner');
        } else {
            return redirect()->back()->with('error', 'Please upload an image');
        }
    }

    public function updateHotel(Request $request, $hotel_id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'file|required|mimes:png,jpg,jpeg|max:2048',
                'hotel_name' => 'required',
                'location' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store($request->hotel_name, 'public');
    
            $hotel = Hotel::find($hotel_id);
            $hotel->hotel_name = $request->hotel_name;
            $hotel->image = $image;
            $hotel->location_id = $request->location;
            $hotel->save();
    
            return redirect()->route('homeOwner');
        } else {
            return redirect()->back()->with('error', 'Please upload an image');
        }
    }

    public function deleteHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $hotel->delete();

        return redirect()->route('homeOwner');
    }
}
