@extends('welcome')

@section('title')
    Add Location
@endsection

@section('content')
    <h1>List Locatin yang sudah ada</h1>
    @if (Session('success'))
        <p>{{ Session('success') }}</p>
    @endif
    <ul>
        @foreach ($locations as $location)
            <li>{{ $location->location_name }}</li>
        @endforeach
        <li>
            <form action="{{ route('postAddLocation') }}" method="POST">
                @csrf
                <label for="location_name">Location Name</label>
                <input type="text" name="location_name">
                <button type="submit">Add Location</button>
            </form>
        </li>
        <li>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif
        </li>
    </ul> 
@endsection