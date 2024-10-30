<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoatController extends Controller
{
    public function show($id)
    {
        $goat = Goat::findOrFail($id);
        return view('goats.show', compact('goat'));
    }
}
