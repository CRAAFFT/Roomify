@extends('welcome')

@section('title')
    Register
@endsection

@section('content')
<form method="POST" action="{{ route('postRegister') }}">
    @csrf
    <div>
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" required>
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="user">Client</option>
            <option value="owner">Owner</option>
        </select>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Retype Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Register</button>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
</form>
@endsection