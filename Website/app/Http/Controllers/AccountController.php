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
    public function delAccount($id)
    {
        // Find the medication by ID and delete it
        $account = DB::table('users')->where('id', $id);
        
        if ($account->exists()) {
            $account->delete();
            return redirect()->back()->with('success', 'Medication deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Medication not found.');
        }
    }
}
