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
    @if (!$hotels->isEmpty())
        <ul>
            @foreach ($hotels as $hotel)
                <li><img src="{{ asset( 'storage' . '/' . $hotel->image) }}" alt="{{ $hotel->hotel_name }}" width="200"></li>
                <li>{{ $hotel->hotel_name }}</li>
                <li>{{ $hotel->location->location_name }}</li>
                <li><a href="{{ route('updateHotel', $hotel->id) }}">Update Hotel</a></li>
            @endforeach
        </ul>
    @else
        <p>Belum ada Hotel yang ditambahkan</p>
    @endif
    <a href="{{ route('addHotel') }}">Add Hotel</a>
@endsection