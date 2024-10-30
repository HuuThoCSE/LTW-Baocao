<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicationController extends Controller
{
    public function getView()
    {
        $medications = DB::table('medications')->get();
        return view('medication',['medications' => $medications]);
    }

    public function addData(Request $request)
    {
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script

        $medication_code = $request->input('medication_code');
        $medication_name = $request->input('medication_name');

        // Insert to database
        DB::table('medications')->insert([
            'medication_code' => $medication_code,
            'medication_name' => $medication_name
        ]);

        $medications = DB::table('medications')->get();
        return view('medication',['medications' => $medications]);
    }

    public function delData($id)
    {
        // Find the medication by ID and delete it
        $medication = DB::table('medications')->where('id', $id);
        
        if ($medication->exists()) {
            $medication->delete();
            return redirect()->back()->with('success', 'Medication deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Medication not found.');
        }
    }

    public function udpData(Request $request, $id)
    {
        // Update medicaion
        $medication_code = $request->input('medication_code');
        $medication_name = $request->input('medication_name');

        DB::table('medications')->where('id', $id)->update(['$medication_code', '$medication_name']);

        // DB::statement("UPDATE medications 
        // SET medication_code = '$medication_code', medication_name = '$medication_name' WHERE id = $id");

        // DB::statement("UPDATE medications 
        //            SET medication_code = ?, medication_name = ? WHERE id = ?", [$medication_code, $medication_name, $id]);

        $medications = DB::table('medications')->get();
        return view('medication',['medications' => $medications]);
    }

}
