<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogModel;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    public function index()
    {
        return view('logs.index', ['logs' => LogModel::all()]);
    }
}
