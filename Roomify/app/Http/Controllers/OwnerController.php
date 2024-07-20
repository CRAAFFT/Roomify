<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelAttachment;
use App\Models\Room;
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

    public function addRoom(Request $request, $hotel_id)
    {
        $validator = Validator::make($request->all(),
            [
                'code_room' =>'required',
                'price' =>'required|numeric',
                'capacity' =>'required|numeric',
                'status' =>'required',
                'type_room' =>'required',
                'image' =>'required|file|mimes:jpg,png,jpeg|max:2024'
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
                'image' =>'required|file|mimes:jpg,png,jpeg|max:2024'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $room = Room::find($room_id)->with('hotel')->first();

        $image = $request->file('image')->store($room->hotel->hotel_name . '/' . $request->code_room, 'public');

        $room->code_room = $request->code_room;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->status = $request->status;
        $room->type_room = $request->type_room;
        $room->image = $image;
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
}
