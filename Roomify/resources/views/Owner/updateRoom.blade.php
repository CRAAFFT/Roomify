@extends('welcome')

@section('title')
    Update Room
@endsection

@section('content')
    <form action="{{ route('putUpdateRoom', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="code_room">Code Room</label>
        <input type="text" name="code_room" value="{{ $room->code_room }}">
        <label for="price">Price</label>
        <input type="number" name="price" value="{{ $room->price }}">
        <label for="capacity">Capacity</label>
        <input type="number" name="capacity" value="{{ $room->capacity }}">
        <label for="image">Room Image</label>
        <input type="file" name="image" required>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
        </select>
        <label for="type_room">Type Room</label>
        <select name="type_room" id="type_room">
            <option value="regular">Regular</option>
            <option value="vip">VIP</option>
        </select>
        <button type="submit">Update Room</button>
    </form>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
@endsection