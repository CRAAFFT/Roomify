@extends('welcome')

@section('title')
    Login
@endsection

@section('content')
<form method="POST" action="{{ route('postLogin') }}">
    @csrf
    <div>
        <label for="login">Email or Username</label>
        <input type="text" name="login" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Login</button>

    @if (Session::has('message'))
        <p>{{ Session::get('message') }}</p>
    @endif
</form>
@endsection