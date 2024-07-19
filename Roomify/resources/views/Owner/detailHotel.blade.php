@extends('welcome')

@section('title')
    Detail Hotel
@endsection

@section('content')
    <img src="{{ asset('storage' . '/' . $hotel->image) }}" alt="" width="200">
    <h3>{{ $hotel->hotel_name }}</h3>
    <p>{{ $hotel->description }}</p>
    <ul>
        @foreach ($rooms as $room)
            <img src="{{ asset('storage' . '/' . $room->image) }}" alt="" width="200">
            <p>{{ $room->code_room }}</p>
            <p>{{ $room->price }}</p>
            <p>{{ $room->capacity }}</p>
            <p>{{ $room->type_room }}</p>
        @endforeach
    </ul>
    <a href="{{ route('addRoom', $hotel->id) }}">Add Room</a>
@endsection