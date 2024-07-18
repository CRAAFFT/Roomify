@extends('welcome')

@section('title')
    Add Hotel
@endsection

@section('content')
    <form action="{{ route('postAddHotel') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <label for="hotel_name">Hotel Name: </label>
        <input type="text" name="hotel_name" required>
        <label for="location">Pilih Lokasi:</label>
        <select name="location" id="location">
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->location_name }}</option>
            @endforeach
        </select>
        <label for="image">Hotel Image</label>
        <input type="file" name="image">
        <button type="submit">Tambah Hotel</button>
    </form>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif
@endsection