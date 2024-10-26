<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getView()
    {
        return view('admin',[]);
    }
    public function getRegisterView()
{
    return view('admin.register');
}

    
    public function register(Request $request)
    {
        // Check if the user is logged in and is the admin
        if (Auth::check() && Auth::user()->email === 'admin@test.vn') {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create new user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash the password
            ]);

            return redirect()->back()->with('success', 'User account created successfully!');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }
}

