<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoatDetailController extends Controller
{
    public function getview(Request $request)
    {
        $goat_id = $request->goat_id;
        return $goat_id;
    }
}
