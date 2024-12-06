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

    public function delData($medication_id)
    {
        // Find the medication by ID and delete it
        $medication = DB::table('medications')->where('medication_id', $medication_id);
        
        if ($medication->exists()) {
            $medication->delete();
            return redirect()->back()->with('success', 'Medication deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Medication not found.');
        }
    }

    public function putData(Request $request, $medication_id)
    {
        // Validate input
        $request->validate([
            'medication_code' => 'required|string|max:255',
            'medication_name' => 'required|string|max:1000',
        ]);

        // Lấy dữ liệu từ request
        $medication_code = $request->input('medication_code');
        $medication_name = $request->input('medication_name');

        // Cập nhật dữ liệu trong bảng
        DB::table('medications')
            ->where('medication_id', $medication_id)
            ->update([
                'medication_code' => $medication_code,
                'medication_name' => $medication_name
            ]);

        // Redirect lại view với thông báo thành công
        return redirect()->back()->with('success', 'Medication updated successfully!');
    }


}
