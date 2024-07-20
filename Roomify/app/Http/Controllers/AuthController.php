<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:16|min:3|unique:users,username,NULL,id,role,' . $request->role,
            'email' => 'required|string|max:255|unique:users,email,NULL,id,role,' . $request->role,
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        if ($request->role == 'owner')
        {
            return redirect()->route('homeOwner');
        }

        return redirect()->route('homeUser');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
        
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            if ($user->role == 'user') 
            {
                return redirect()->route('homeUser');
            }
            else if ($user->role == 'owner') 
            {
                return redirect()->route('homeOwner');
            }
            else if ($user->role == 'admin')
            {
                return redirect()->route('homeAdmin');
            }
        }

        return redirect()->back()->with('message', 'Invalid Credential');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('homeUser');
    }
}