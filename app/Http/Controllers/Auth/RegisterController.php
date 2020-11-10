<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
    	return view('auth.register');
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required|max:255',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:6|confirmed'
    	]);

    	User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => Hash::make($request->password)
    	]);
    	
    	auth()->attempt($request->only('email', 'password'));
    	
    	return redirect()->route('projects');
    }
}
