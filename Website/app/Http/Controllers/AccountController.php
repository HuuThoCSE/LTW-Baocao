<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function getView()
    {
        $users = DB::table('users')->get();
        return view('account',['users' => $users]);
    }
}
