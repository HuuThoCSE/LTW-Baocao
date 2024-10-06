<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function getView()
    {
        return view('health-check',[]);
    }
}
