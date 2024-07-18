@extends('welcome')

@section('title')
    Home
@endsection

@section('content')
    <nav>
        <ul>
            <li>{{ Auth::user()->username }}</li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </nav>
    <h1>Welcome to the Hotel Booking System</h1>
    <ul>
        @foreach ($hotels as $hotel)
            <li>{{ $hotel->hotel_name }}</li>
        @endforeach
    </ul>
@endsection