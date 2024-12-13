<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TypeFoodModel;
class TypeFoodController extends Controller
{
    public function index()
    {
        $type_foods = DB::table('type_foods')->get();

        
        return view('foods.types',['type_foods' => $type_foods]);
    }  
    // public function add(Request $request)
    // {
    //     // Debugging: Check all request data
    //     // dd($request->all()); // This will show all request data and stop the script

    //     $type_food_code = $request->input('type_food_code');
    //     $type_food_name_vn = $request->input('type_food_name_vn');
    //     $type_food_name_el = $request->input('type_food_name_el');
     

    //     // Insert to database
    //     DB::table('type_foods')->insert([
    //         'type_food_code' => $type_food_code,
    //         'type_food_name_vn' => $type_food_name_vn,
    //         'type_food_name_el' => $type_food_name_el,
          
    //     ]);


    //     $type_foods = DB::table('type_foods')->get();
    //     return view('foods.types',['type_foods' => $type_foods]);
    // } 

    public function add(Request $request)
    {
        
        // Validate input
        $validated = $request->validate([
            'type_food_code' => 'required|unique:type_foods,type_food_code|max:8',
            'type_food_name_vn' => 'required|max:250',
            'type_food_name_el' => 'required|max:250',
        ]);
        

        // Create new food type record
        TypeFoodModel::create([
            'type_food_code' => $validated['type_food_code'],
            'type_food_name_vn' => $validated['type_food_name_vn'],
            'type_food_name_el' => $validated['type_food_name_el'],
        ]);

        // Redirect with success message
        return redirect()->route('typefoods.index')->with('success', 'Food type added successfully!');
    }


    public function delFood($id)
    {
        // Find the medication by ID and delete it
        $type_foods = DB::table('type_foods')->where('id', $id);

        if ($type_foods->exists()) {
            $type_foods->delete();
            return redirect()->back()->with('success', ' Type food deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Type food not found.');
        }
    }
    public function udpFood(Request $request, $id)
    {
        // Update medicaion
        $type_food_code = $request->input('type_food_code');
        $type_food_name_vn = $request->input('type_food_name_vn');
        $type_food_name_el = $request->input('type_food_name_el');
     

        DB::table('type_foods')->where('id', $id)->update([
            'type_food_code'=>$type_food_code ,
            'type_food_name_vn'=>$type_food_name_vn,
            'type_food_name_el'=>$type_food_name_el]);


        return redirect()->route('typefoods.index')->with('success', 'Food updated successfully.');
    }
}
