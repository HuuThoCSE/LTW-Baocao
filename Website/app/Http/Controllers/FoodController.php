<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function getView()
    {
        $foods = DB::table('foods')->get();
        return view('food',['foods' => $foods]);
    }
    public function addFood(Request $request)
    {
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script

        $food_code = $request->input('food_code');
        $food_name_vn = $request->input('food_name_vn');
        $food_name_el = $request->input('food_name_el');
        $expiry_date = $request->input('expiry_date');
        
        // Insert to database
        DB::table('foods')->insert([
            'food_code' => $food_code,
            'food_name_vn' => $food_name_vn,
            'food_name_el' => $food_name_el,
            'expiry_date' => $expiry_date
        ]);

        $foods = DB::table('foods')->get();
        return view('food',['foods' => $foods]);
    }


    public function delFood($id)
    {
        // Find the medication by ID and delete it
        $food = DB::table('foods')->where('id', $id);
        
        if ($food->exists()) {
            $food->delete();
            return redirect()->back()->with('success', 'Food deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Food not found.');
        }
    }
    public function udpFood(Request $request, $id)
    {
        // Update medicaion
        $food_code = $request->input('farm_code');
        $food_name_vn = $request->input('food_name_vn');
        $food_name_el = $request->input('food_name_el');
        $expiry_date = $request->input('expiry_date');

        DB::table('foods')->where('id', $id)->update([
            'food_code'=>$food_code ,
            'food_name_vn'=>$food_name_vn,
            'food_name_el'=>$food_name_el,
            'expiry_date'=>$expiry_date]);

        $farms = DB::table('foods')->get();
        // return view('farm/dashboard',['farms' => $farms]);
        return redirect()->route('food')->with('success', 'Food updated successfully.');
    }
    
}

