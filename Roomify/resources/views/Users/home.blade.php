@extends('welcome')

@section('title')
Home
@endsection

@section('content')
    <nav>
        <ul>
            @if(Auth::check())
                <li>{{ Auth::user()->username }}</li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endif
        </ul>
    </nav>
    <h1>Welcome to the Hotel Booking System</h1>
    <ul>
        @foreach ($hotels as $hotel)
            <li><img src="{{ asset('storage' . '/' . $hotel->image) }}" alt="{{ $hotel->hotel_name }}"></li>
            <li>{{ $hotel->hotel_name }}</li>
            <li>{{ $hotel->location->location_name }}</li>
            <li><a href="{{ route('detailHotel', $hotel->id) }}">Detail Hotel</a></li>
        @endforeach
    </ul>
@endsection