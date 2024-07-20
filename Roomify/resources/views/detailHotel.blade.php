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
            @if (Auth::user->role == 'admin' || Auth::user->role == 'owner')
            <a href="{{ route('updateRoom', $room->id) }}">Update Room</a>
            <form action="{{ route('deleteRoom', $room->id) }}" method="POST">
                @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete Room</button>
                </form>
            @endif
        @endforeach
    </ul>
    @if (Auth::check())
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
            <a href="{{ route('addRoom', $hotel->id) }}">Add Room</a>
        @endif
    @endif
@endsection