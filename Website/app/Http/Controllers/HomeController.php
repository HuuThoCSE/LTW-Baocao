<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirectToDashboard ()
    {
        switch (Auth::user()->role_id) {
            case 1:
//                return view('main-dashboard');
                return redirect()->route('farms.index');
            case 2:
                return view('dashboard');
            case 3:
                return view('dashboard.it');
            case 4:
                return view('dashboard');
            default:
                abort(403, 'Unauthorized access');
        }
    }
}
