<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoatManagementController extends Controller
{
    public function getView()
    {
        return view('goat-management',[]);
    }
}
