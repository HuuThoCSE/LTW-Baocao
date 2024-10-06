<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getViewDashboard()
    {
        $name = 'Tho';
        return view('dashboard',[]);
    }

    public function getViewQLD()
    {
        $name = 'Tho';
        return view('quanlyde',[]);
    }
}
