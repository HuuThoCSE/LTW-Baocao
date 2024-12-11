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

        $breeds = DB::table('farm_breeds')
            ->where('farm_id', $farm_id) // Lọc theo farm_id
            ->get(); // Lấy danh sách các giống dê

        $goats = DB::table('farm_goats')
            ->where('farm_goats.farm_id', $farm_id) // Lọc theo farm_id
            ->join('farms', 'farm_goats.farm_id', '=', 'farms.farm_id')
            ->join('farm_breeds', 'farm_goats.breed_id', '=', 'farm_breeds.breed_id')
            ->select('farm_goats.*', 'farms.farm_name', 'farm_breeds.breed_name_vie')
            ->get();

        // Truyền dữ liệu vào view
        return view('goats.dashboard', ['goats' => $goats, 'breeds' => $breeds]);
    }

    public function showTransferHistoryQuery($goatId)
    {
        return BarnTransferModel::where('goat_id', $goatId)
            ->with(['oldBarn', 'newBarn', 'transferredBy'])
            ->orderBy('transferred_at', 'desc');
    }

    public function show($id)
    {
        $goat = GoatModel::join('farm_breeds', 'farm_goats.breed_id', '=', 'farm_breeds.breed_id')  // Join bảng farm_breeds
            ->where('farm_goats.goat_id', $id)  // Nếu $id là goat_id
            ->join('farms', 'farm_goats.farm_id', '=', 'farms.farm_id') // Join bảng farms
            ->select(
                'farms.farm_name',
                'farm_goats.goat_id',
                'farm_goats.goat_name',
                'farm_goats.goat_age',
                'farm_goats.origin',
                'farm_goats.breed_id',
                'farm_breeds.breed_name_vie'
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

//        dd($currentBarnName);

//        dd($lastGoatWeight);

        $barns = BarnModel::where('farm_id', Session::get('farm_id'))->get();

//        dd($barns);

        return view('goats.show', ['goat' => $goat,
                                        'goatWeights' => $goatWeights,
                                        'lastGoatWeight' => $lastGoatWeight,
                                        '$transfers' => $transfers,
                                        'currentBarn' => $currentBarn,
                                        'currentBarnName' => $currentBarnName,
                                        'barns' => $barns
                                    ]);
    }

    public function add(Request $request)
    {
//        dd($request->all());

        // Validate incoming request data
        $request->validate([
            'goat_name' => 'required|string|max:255', // GoatModel name is required and should be a string
            'goat_age' => 'required|integer', // GoatModel age is required and should be an integer
            'origin' => 'required|string', // Origin is required and should be a string
            'breed_id' => 'required|integer', // BreedModel ID is required and should be an integer
        ]);


        // Debugging: Check all request data
//         dd($request->all()); // This will show all request data and stop the script

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

            // Return success message and redirect
            return redirect()->route('goats.index')->with('success', 'Goat added successfully');
        } catch (\Exception $e) {
            // LogModel the error for debugging
            Log::error('Error inserting breed: ' . $e->getMessage());

            // Return error message and redirect
            return redirect()->route('goats.index')->with('error', 'Failed to add goat. Please try again.');
        }

    }


    public function delGoat($goat_id)
    {

    // Find the goat by its ID
    $goat = DB::table('farm_goats')->where('goat_id', $goat_id)->first();

    if ($goat) {
        // Delete the goat if found
        DB::table('farm_goats')->where('goat_id', $goat_id)->delete();
        return redirect()->back()->with('success', 'GoatModel deleted successfully.');
    } else {
        // If the goat doesn't exist, return an error
        return redirect()->back()->with('error', 'GoatModel not found.');
    }


    }
    public function udpGoat(Request $request, $goat_id)
    {
        // Lấy dữ liệu từ request
        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $farm_id = $request->input('farm_id'); // Lấy farm_id từ form
        $breed_id = $request->input('breed_id');

        // Kiểm tra farm_id có tồn tại không
        if (!$farm_id) {
            return redirect()->back()->with('error', 'FarmModel ID is missing.');
        }

        // Cập nhật bảng farms
         // Cập nhật thông tin cho con dê
        $updated = DB::table('farm_goats')->where('goat_id', $goat_id)->update([
            'goat_name' => $goat_name,
            'goat_age' => $goat_age,
            'origin' => $origin,
            'farm_id' => $farm_id, // Cập nhật farm_id cho con dê
            'breed_id' => $breed_id, // Cập nhật breed_id nếu cần
        ]);

        // Truy xuất lại danh sách
        $farms = DB::table('farm_goats')->get();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('goats.index')->with('success', 'FarmModel updated successfully.');
    }

    public function addWeight(Request $request, $goat_id)
    {

        // Validate incoming request data
        $request->validate([
            'weight' => 'required|numeric', // Weight is required and should be a number
        ]);

        // Get the weight from the request
        $weight = $request->input('weight');

        // Insert the new weight into the database
        DB::table('goat_weights')->insert([
            'goat_id' => $goat_id,
            'weight' => $weight,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user_id = Auth::user()->user_id;

        LogModel::create([
            'user_id' => $user_id,  // ID của người dùng thực hiện hành động
            'description' => "User with ID {$user_id} added weight information for goat with ID {$goat_id} value {$weight}."
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Thêm cân nặng thành công cho dê.');
    }

    public function addDisease($request, $goat_id)
    {
        return redirect()->back()->with('success', 'Thêm bệnh thành công cho dê.');
    }

    public function addFood($request, $goat_id)
    {
        return redirect()->back()->with('success', 'Thêm thức ăn thành công cho dê.');
    }

    public function transferBarn(Request $request, $goat_id)
    {
        $validated = $request->validate([
            'barn_id' => 'required|exists:Barns,id',
        ]);

        // Lấy thông tin con dê
        $goat = GoatModel::findOrFail($goat_id);
        $oldBarnId = $goat->barn_id;

        // Kiểm tra xem chuồng mới có khác chuồng hiện tại không
        if ($oldBarnId == $validated['barn_id']) {
            return redirect()->back()->with('error', 'Chuồng mới phải khác chuồng hiện tại.');
        }

        // Cập nhật chuồng mới
        $goat->barn_id = $validated['barn_id'];
        $goat->save();

        // Ghi lịch sử chuyển chuồng
        BarnTransferModel::create([
            'goat_id' => $goat->goat_id,
            'old_barn_id' => $oldBarnId,
            'new_barn_id' => $validated['barn_id'],
            'transferred_by' => auth()->id(),
        ]);

        // Ghi log chuyển chuồng
        LogModel::create([
            'user_id' => auth()->id(),
            'description' => "User with ID " . auth()->id() . " transferred goat with ID {$goat->id} from barn ID {$oldBarnId} to barn ID {$validated['barn_id']}."
        ]);

        return redirect()->back()->with('success', 'Chuyển chuồng thành công!');
    }

}
