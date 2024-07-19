@extends('welcome')

@section('title')
    Update Hotel
@endsection

@section('content')
<form action="{{ route('putUpdateHotel', $hotel->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
        <label for="hotel_name">Hotel Name: </label>
        <input type="text" name="hotel_name" required value="{{ $hotel->hotel_name }}">
        <label for="location">Pilih Lokasi:</label>
        <select name="location" id="location">
            @foreach ($locations as $location)
                <option value="{{ $location->id }}" @if($hotel->location_id == $location->id) selected @endif>{{ $location->location_name }}</option>
            @endforeach
        </select>
        <label for="image">Hotel Image</label>
        <input type="file" name="image">
        <button type="submit">Update Hotel</button>
    </form>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
@endsection