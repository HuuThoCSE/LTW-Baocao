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
            SELECT goats.*, breeds.breed_name, farms.farm_name,farms.location,goat_weighs.weight
            FROM goats 
            JOIN breeds ON goats.breed_id = breeds.breed_id 
            JOIN farms ON goats.farm_id = farms.farm_id
            JOIN goat_weighs ON goats.goat_id = goat_weighs.goat_id
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
            ->join('breeds', 'goats.breed_id', '=', 'breeds.breed_id')
            ->select('goats.*', 'farms.farm_name', 'breeds.breed_name') // Lấy farm_name và breed_name
            ->get();
               
        // Truyền dữ liệu vào view
        return view('goats.listgoat', ['goats' => $goats]);
    }

    public function addGoat(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'goat_name' => 'required|string|max:255', // Goat name is required and should be a string
            'goat_age' => 'required|integer', // Goat age is required and should be an integer
            'origin' => 'required|string', // Origin is required and should be a string
            'farm_id' => 'required|integer|exists:farms,farm_id',  // Farm ID is required, should be an integer, and must exist in the 'farms' table
            'breed_id' => 'required|integer|exists:breeds,breed_id', // Breed ID is required, should be an integer, and must exist in the 'breeds' table
        ]);
    
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script
   
        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $farm_id = $request->input('farm_id'); 
        $breed_id = $request->input('breed_id'); 

        // Insert to database
     
        

        try {
            // Insert the new goat into the database
            DB::table('goats')->insert([
                'goat_name' => $goat_name,
                'goat_age' => $goat_age,
                'origin' => $origin,
                'farm_id' => $farm_id,
                'breed_id' => $breed_id,
            ]);
    
            // Thêm thông báo thành công
            return redirect()->route('goats.list')->with('success', 'Goat added successfully');
        } catch (\Exception $e) {
            // Thêm thông báo lỗi
            return redirect()->route('goats.list')->with('error', 'Failed to add goat. Please try again.');
        }


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
