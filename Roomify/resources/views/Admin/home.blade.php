@extends('welcome')

@section('title')
    Home Admin
@endsection

@section('content')
    <nav>
        <ul>
            <li>{{ Auth::user()->username }}</li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </nav>
    <h1>Ini halaman admin cuy</h1>
    <ul>
        @foreach ($hotels as $hotel)
            <li><img src="{{ asset('storage' . '/' . $hotel->image) }}" alt="" width="200"></li>
            <li>{{ $hotel->hotel_name }}</li>
            <li>{{ $hotel->location->location_name }}</li>
            <li>{{ $hotel->status }}</li>
            <li><a href="{{ route('updateHotel', $hotel->id) }}">Update Hotel</a></li>
            <li>
                <form action="{{ route('deleteHotel', $hotel->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you Sure?')">Delete Hotel</button>
                </form>
            </li>
            <li><a href="{{ route('detailHotel', $hotel->id) }}">Detail Hotel</a></li>
        @endforeach
    </ul>
    <a href="{{ route('addHotel') }}">Add Hotel</a>
    <a href="{{ route('addLocation') }}">Add Location</a>
@endsection