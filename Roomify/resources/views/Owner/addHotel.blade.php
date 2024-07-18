@extends('welcome')

@section('title')
    Add Hotel
@endsection

@section('content')
    <form action="{{ route('postAddHotel') }}" method="POST">
    @csrf
        <label for="hotel_name">Hotel Name: </label>
        <input type="text" name="hotel_name" required>
        <label for="location">Pilih Lokasi:</label>
        <select name="location" id="location">
            <option value="bali">Bali</option>
            <option value="aceh">Aceh</option>
            <option value="medan">Medan</option>
            <option value="padang">Padang</option>
            <option value="pekanbaru">Pekanbaru</option>
            <option value="batam">Batam</option>
            <option value="jambi">Jambi</option>
            <option value="bengkulu">Bengkulu</option>
            <option value="palembang">Palembang</option>
            <option value="pangkalpinang">Pangkalpinang</option>
            <option value="bandar_lampung">Bandar Lampung</option>
            <option value="jakarta">Jakarta</option>
            <option value="bandung">Bandung</option>
            <option value="semarang">Semarang</option>
            <option value="yogyakarta">Yogyakarta</option>
            <option value="surabaya">Surabaya</option>
            <option value="serang">Serang</option>
            <option value="denpasar">Denpasar</option>
            <option value="mataram">Mataram</option>
            <option value="kupang">Kupang</option>
            <option value="pontianak">Pontianak</option>
            <option value="palangkaraya">Palangkaraya</option>
            <option value="banjarmasin">Banjarmasin</option>
            <option value="samarinda">Samarinda</option>
            <option value="manado">Manado</option>
            <option value="gorontalo">Gorontalo</option>
            <option value="palu">Palu</option>
            <option value="makassar">Makassar</option>
            <option value="kendari">Kendari</option>
            <option value="ambon">Ambon</option>
            <option value="ternate">Ternate</option>
            <option value="manokwari">Manokwari</option>
            <option value="jayapura">Jayapura</option>
        </select>
        <label for="attachments">Hotel Image</label>
        <input type="file" name="attachments[]" multiple>
        <button type="submit">Tambah Hotel</button>
    </form>
@endsection