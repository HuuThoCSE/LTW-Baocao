<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index()
    {
        // Join bảng foods với bảng type_foods để lấy tên loại thực phẩm
        $foods = DB::table('foods')
        ->join('type_foods', 'foods.type_food_id', '=', 'type_foods.type_food_id')
        ->select('foods.*', 'type_foods.type_food_name_vn as type_food_name_vn')
        ->get();

        $type_foods = DB::table('type_foods')->select('type_food_id', 'type_food_name_vn')->get(); // Lấy danh sách loại thức ăn

        return view('foods.index', ['foods' => $foods, 'type_foods' => $type_foods]);
    }

    public function add(Request $request)
    {
        // Lấy dữ liệu từ request
        $food_code = $request->input('food_code');
        $food_name_vn = $request->input('food_name_vn');
        $food_name_el = $request->input('food_name_el');
        $expiry_date = $request->input('expiry_date');
        $type_food_id = $request->input('type_food_id');

        // Chèn dữ liệu vào bảng foods
        DB::table('foods')->insert([
            'food_code' => $food_code,
            'food_name_vn' => $food_name_vn,
            'food_name_el' => $food_name_el,
            'expiry_date' => $expiry_date,
            'type_food_id' => $type_food_id,
        ]);

        return redirect()->route('foods.index')->with('success', 'Food added successfully.');
    }

    public function delFood($id)
    {
        // Xóa thực phẩm theo ID
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
        // Lấy dữ liệu từ request để cập nhật
        $food_code = $request->input('food_code');
        $food_name_vn = $request->input('food_name_vn');
        $food_name_el = $request->input('food_name_el');
        $expiry_date = $request->input('expiry_date');
        $type_food_id = $request->input('type_food_id');

        // Cập nhật dữ liệu trong bảng foods
        DB::table('foods')->where('food_id', $id)->update([
            'food_code' => $food_code,
            'food_name_vn' => $food_name_vn,
            'food_name_el' => $food_name_el,
            'expiry_date' => $expiry_date,
            'type_food_id' => $type_food_id,
        ]);

        return redirect()->route('foods.index')->with('success', 'Food updated successfully.');
    }
}