<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoatController extends Controller
{
    public function show($id)
    {
        // $goat = DB::table('goats')
        //         ->where('goat_id', $id)
        //         ->first();

        $goat = DB::select("
            SELECT goats.*, breeds.breed_name 
            FROM goats 
            JOIN breeds ON goats.breed_id = breeds.breed_id 
            WHERE goats.goat_id = ?", 
            [$id]
        );
    
        if (!$goat) {
            abort(404);
        }

        $goatWeights = DB::select("
            SELECT *
            FROM goat_weighs
            WHERE goat_id = ?", 
            [$id]
        );
        
        return view('goats.show', ['goat' => $goat[0], 'goatWeights' => $goatWeights]);
    }
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        // $goats = DB::table('goats')->get(); // Thực hiện truy vấn để lấy dữ liệu
        $goats = DB::table('goats')
               ->join('farms', 'goats.farm_id', '=', 'farms.farm_id')
               ->select('goats.*', 'farms.farm_name') // Including farm name in the list of goats
               ->get();
        // Truyền dữ liệu vào view
        return view('goats.listgoat', ['goats' => $goats]);
    }

    public function addGoat(Request $request)
    {
        // $request->validate([
        //     'goat_name' => 'required|string|max:255',
        //     'goat_age' => 'required|integer',
        //     'origin' => 'required|string',
        //     'farm_id' => 'required|integer',  // Ensure farm_id is included in the form
        // ]);
    
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script
   
        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $farm_id = $request->input('farm_id'); 

        // Insert to database
     
        

        // Insert the new goat into the database
        DB::table('goats')->insert([
            'goat_name' => $goat_name,
            'goat_age' => $goat_age,
            'origin' => $origin,
            'farm_id' => $farm_id,
            ]);

        $farms = DB::table('goats')->get();
        // return view('goat.listgoat',['goats' => $goats]);
        return redirect()->route('goats.list')->with('success', 'Goat added successfully');
    }

    
    public function delGoat($goat_id)
    {
        // Find the medication by ID and delete it
        $goat = DB::table('goats')->where('goat_id', $goat_id);
        
        if ($goat->exists()) {
            $goat->delete();
            return redirect()->back()->with('success', 'Farm deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Farm not found.');
        }
    }
    public function udpGoat(Request $request, $goat_id)
    {
        // Update medicaion
        $goat_name = $request->input('goat_name');
        $location = $request->input('location');
        $owner_id = $request->input('owner_id');

        DB::table('farms')->where('farm_id', $farm_id)->update([
            'farm_name'=>$farm_name ,
            'goat_age'=>$goat_age,
            'origin'=>$origin]);

        $farms = DB::table('goats')->get();
        // return view('farm/dashboard',['farms' => $farms]);
        return redirect()->route('goats')->with('success', 'Farm updated successfully.');
    }
    // public function createGoatForm()
    // {
    //     // Fetch farms from the database
    //     $farms = DB::table('farms')->get();
    // dd($farms);
    //     // Pass the farms list to the view
    //     return view('goats.add', ['farms' => $farms]);
    // }
    // public function edit($goat_id)
    // {
    //     $goat = DB::table('goats')->where('goat_id', $goat_id)->first();
    //     $farms = DB::table('farms')->get();
        
    //     return view('goats.edit', ['goat' => $goat, 'farms' => $farms]);
    // }
    // public function index()
    // {
    //     // Fetch all farms
    //     $farms = DB::table('farms')->get();

    //     // Fetch goats and pass both goats and farms to the view
    //     $goats = DB::table('goats')
    //             ->join('farms', 'goats.farm_id', '=', 'farms.farm_id')
    //             ->select('goats.*', 'farms.farm_name')
    //             ->get();

    //     return view('goats.list', ['goats' => $goats, 'farms' => $farms]);
    // }
}
