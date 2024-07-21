<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelAttachment;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;

class ManageController extends Controller
{
    public function addHotel(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'file|required|mimes:png,jpg,jpeg|max:2048',
                'hotel_name' => 'required',
                'description' => 'required',
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
                'description' => $request->description,
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
                'image' => 'file|mimes:png,jpg,jpeg|max:2048',
                'hotel_name' => 'required',
                'location' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $hotel = Hotel::find($hotel_id);

        if ($request->hasFile('image')) 
        {
            $image = $request->file('image')->store($request->hotel_name, 'public');
            $hotel->image = $image;
        }

        $hotel->hotel_name = $request->hotel_name;
        $hotel->location_id = $request->location;
        if ($request->status) 
        {
            $hotel->status = $request->status;
        }
        $hotel->save();

        if (Auth::user()->role != 'admin')
        {
            return redirect()->route('homeOwner');
        }
        else if (Auth::user()->role == 'admin')
        {
            return redirect()->route('homeAdmin');
        }
    }

    public function deleteHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $hotel->delete();

        return redirect()->route('homeOwner');
    }

    public function addRoom(Request $request, $hotel_id)
    {
        $validator = Validator::make($request->all(),
            [
                'code_room' =>'required',
                'price' =>'required|numeric',
                'capacity' =>'required|numeric',
                'status' =>'required',
                'type_room' =>'required',
                'image' =>'file|mimes:jpg,png,jpeg|max:2024|required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $hotel = Hotel::find($hotel_id);
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store($hotel->hotel_name . '/' . $request->code_room, 'public');
            $room = Room::create([
                'code_room' => $request->code_room,
                'price' => $request->price,
                'capacity' => $request->capacity,
                'image' => $image,
                'status' => $request->status,
                'room_type' => $request->room_type,
                'hotel_id' => $hotel->id,
            ]);
            return redirect()->route('detailHotel', $hotel->id);
        } else {
            return redirect()->back()->with('error', 'Image is required');
        }

    }

    public function updateRoom(Request $request, $room_id)
    {
        $validator = Validator::make($request->all(),
            [
                'code_room' =>'required',
                'price' =>'required|numeric',
                'capacity' =>'required|numeric',
                'status' =>'required',
                'type_room' =>'required',
                'image' =>'file|mimes:jpg,png,jpeg|max:2024'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $room = Room::find($room_id)->with('hotel')->first();

        if ($request->hasFile('image')) 
        {
            $image = $request->file('image')->store($room->hotel->hotel_name . '/' . $request->code_room, 'public');
            $room->image = $image;
        }

        $room->code_room = $request->code_room;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->status = $request->status;
        $room->type_room = $request->type_room;
        $room->save();

        return redirect()->route('detailHotel', $room->hotel->id);
    }

    public function deleteRoom($room_id)
    {
        $room = Room::find($room_id);
        $hotel_id = $room->hotel_id;
        $room->delete();

        return redirect()->route('detailHotel', $hotel_id);
    }
    
    public function addLocation(Request $request)
    {
        Location::create([
            'location_name' => $request->location_name,
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan ' . $request->location_name);
    }

    public function deleteLocation($location_id)
    {
        try {
            $location = Location::find($location_id);
            $location->delete();
            return redirect()->route('addLocation');
        } catch (Exception $e) {
            return redirect()->route('addLocation')->with('error', $e->getMessage());
        }
    }

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('homeAdmin');
    }
}
