<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BarnModel;
use App\Models\BarnTransferModel;
use App\Models\GoatModel;
use App\Models\GoatWeightModel;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FarmModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class GoatController extends Controller
{
    public function index()
    {
        $farm_id = Session::get('farm_id');
        
        // Lấy giống cho trang trại (farm_breeds thay vì breeds)
        $breeds = DB::table('farm_breeds')
            ->where('farm_id', $farm_id) 
            ->get(); 
    
        // Lấy dê cho trang trại
        $goats = DB::table('farm_goats')
            ->where('farm_goats.farm_id', $farm_id)
            ->join('farms', 'farm_goats.farm_id', '=', 'farms.farm_id')
            ->join('farm_breeds', 'farm_goats.breed_id', '=', 'farm_breeds.breed_id')  // Đổi từ breeds thành farm_breeds
            ->select('farm_goats.*', 'farms.farm_name', 'farm_breeds.breed_name_vie') // Đổi từ breeds thành farm_breeds
            ->get();
        
        // Lấy tất cả trang trại
        $farms = DB::table('farms')->get();
    
        // Thêm thông tin về giống cho các trang trại (nếu cần)
        foreach ($farms as $farm) {
            $farm->breeds = DB::table('farm_breeds') // Đổi từ breeds thành farm_breeds
                ->where('farm_id', $farm->farm_id)
                ->get(); 
        }
    
        // Trả về view với dữ liệu dê, giống và trang trại
        return view('goats.dashboard', [
            'goats' => $goats, 
            'breeds' => $breeds, 
            'farms' => $farms  // Truyền biến $farms vào view
        ]);

        $farms = FarmModel::all();

        $farms = FarmModel::all();

        // Truyền dữ liệu vào view
        return view('goats.index', ['goats' => $goats, 'breeds' => $breeds, 'farms' => $farms]);
    }
    
    public function showTransferHistoryQuery($goatId)
    {
        return BarnTransferModel::where('goat_id', $goatId)
            ->with(['oldBarn', 'newBarn', 'transferredBy'])
            ->orderBy('transferred_at', 'desc');
    }

    public function show($id)
    {
        $goat = GoatModel::join('farm_breeds', 'farm_goats.breed_id', '=', 'farm_breeds.breed_id')  // Đổi từ breeds thành farm_breeds
            ->where('farm_goats.goat_id', $id)  // Nếu $id là goat_id
            ->join('farms', 'farm_goats.farm_id', '=', 'farms.farm_id') // Join bảng farms
            ->select(
                'farms.farm_name',
                'farm_goats.goat_id',
                'farm_goats.goat_name',
                'farm_goats.goat_age',
                'farm_goats.origin',
                'farm_goats.breed_id',
                'farm_breeds.breed_name_vie' // Đổi từ breeds thành farm_breeds
            )
            ->first();

        // Kiểm tra nếu không tìm thấy con dê với ID đó
        if (!$goat) {
            // Nếu không tìm thấy, bạn có thể redirect hoặc thông báo lỗi
            return redirect()->route('goats.dashboard')->with('error', 'Goat not found');
        }

        $goatWeights = GoatWeightModel::where('goat_id', $goat->goat_id)->get();

        $lastGoatWeight = $goat->weights()->latest('created_at')->first();

        // Lấy lịch sử chuyển chuồng
        $transfers = $this->showTransferHistoryQuery($id)->get();

        $currentBarn = BarnTransferModel::where('goat_id', $id)
            ->with('newBarn') // Eager load tên chuồng mới
            ->orderBy('transferred_at', 'desc')
            ->first();

        $currentBarnName = $currentBarn ? $currentBarn->newBarn->name : 'Chưa có chuồng';

        $barns = BarnModel::where('farm_id', Session::get('farm_id'))->get();

        return view('goats.show', ['goat' => $goat,
                                        'goatWeights' => $goatWeights,
                                        'lastGoatWeight' => $lastGoatWeight,
                                        'transfers' => $transfers,
                                        'currentBarn' => $currentBarn,
                                        'currentBarnName' => $currentBarnName,
                                        'barns' => $barns
                                    ]);
    }

    public function add(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'goat_name' => 'required|string|max:255',
            'goat_age' => 'required|integer',
            'origin' => 'required|string',
            'breed_id' => 'required|integer', // Ensure it refers to farm_breeds
        ]);

        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $breed_id = $request->input('breed_id');

        $farm_id = Session::get('farm_id');

        try {
            // Insert the new goat into the database
            DB::table('farm_goats')->insert([
                'goat_name' => $goat_name,
                'goat_age' => $goat_age,
                'origin' => $origin,
                'farm_id' => $farm_id,
                'breed_id' => $breed_id,
            ]);

            return redirect()->route('goats.index')->with('success', 'Goat added successfully');
        } catch (\Exception $e) {
            Log::error('Error inserting breed: ' . $e->getMessage());
            return redirect()->route('goats.index')->with('error', 'Failed to add goat. Please try again.');
        }
    }

    public function delGoat($goat_id)
    {
        $goat = DB::table('farm_goats')->where('goat_id', $goat_id)->first();

        if ($goat) {
            DB::table('farm_goats')->where('goat_id', $goat_id)->delete();
            return redirect()->back()->with('success', 'GoatModel deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'GoatModel not found.');
        }
    }

    public function udpGoat(Request $request, $goat_id)
    {
        $goat = DB::table('farm_goats')->where('goat_id', $goat_id)->first();
        if (!$goat) {
            return redirect()->back()->with('error', 'Không tìm thấy con dê.');
        }

        $validated = $request->validate([
            'goat_name' => 'required|string|max:255',
            'goat_age' => 'required|integer|min:0',
            'origin' => 'nullable|string|max:255',
            'farm_id' => 'required|exists:farms,farm_id',
            'breed_id' => 'required|exists:farm_breeds,breed_id',  // Ensure it refers to farm_breeds
        ]);

        $goat_name = $validated['goat_name'];
        $goat_age = $validated['goat_age'];
        $origin = $validated['origin'];
        $farm_id = $validated['farm_id'];
        $breed_id = $validated['breed_id'];

        if ($goat->goat_name == $goat_name && $goat->goat_age == $goat_age && $goat->origin == $origin && $goat->farm_id == $farm_id && $goat->breed_id == $breed_id) {
            return redirect()->back()->with('info', 'Không có thay đổi nào.');
        }

        $updated = DB::table('farm_goats')->where('goat_id', $goat_id)->update([
            'goat_name' => $goat_name,
            'goat_age' => $goat_age,
            'origin' => $origin,
            'farm_id' => $farm_id,
            'breed_id' => $breed_id,
        ]);

        if ($updated) {
            return redirect()->route('goats.index')->with('success', 'Thông tin con dê đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }
    }

    public function addWeight(Request $request, $goat_id)
    {
        $request->validate([
            'weight' => 'required|numeric',
        ]);

        $weight = $request->input('weight');

        DB::table('goat_weights')->insert([
            'goat_id' => $goat_id,
            'weight' => $weight,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user_id = Auth::user()->user_id;

        LogModel::create([
            'user_id' => $user_id,
            'description' => "User with ID {$user_id} added weight information for goat with ID {$goat_id} value {$weight}."
        ]);

        return redirect()->back()->with('success', 'Thêm cân nặng thành công cho dê.');
    }

    public function transferBarn(Request $request, $goat_id)
    {
        $barn_id = $request->input('barn_id');
        $goat = GoatModel::findOrFail($goat_id);

        $barn_transfer = new BarnTransferModel();
        $barn_transfer->goat_id = $goat_id;
        $barn_transfer->barn_id = $barn_id;
        $barn_transfer->transferred_at = now();
        $barn_transfer->transferred_by = Auth::id();
        $barn_transfer->save();

        $goat->current_barn = $barn_id;
        $goat->save();

        return redirect()->route('goats.show', ['id' => $goat_id])
            ->with('success', 'Dê đã được chuyển chuồng thành công');
    }
}
