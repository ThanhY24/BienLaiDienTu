<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeModel;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function index(){
        $dataFee = FeeModel::where("user_id", "=", Auth::id())->get();
        return view("pages.Fee.FeePages")->with("dataFee", $dataFee);
    }
    public function createFee(Request $request){
        $request->validate([
            'fee_id' => 'required|string',
            'fee_unit' => 'required|string',
            'fee_name' => 'required|string',
            'fee_cost' => 'required|string',
        ]);
        $dataCreateFee = $request->all();
        $dataCreateFee['user_id'] = Auth::id();
        $existingFee = FeeModel::where('fee_id', $dataCreateFee['fee_id'])->where('user_id', Auth::id())->first();
        if ($existingFee) {
            return redirect("/fee")->with('message', 'Mã phí, lệ phí đã tồn tại.')->with('type', 'ERR');
        }
        if (FeeModel::create($dataCreateFee)) {
            return redirect("/fee")->with('message', 'Thêm phí, lệ phí thành công.')->with('type', 'OK');
        } else {
            return redirect("/fee")->with('message', 'Có lỗi khi thêm phí, lệ phí.')->with('type', 'ERR');
        }
    }
}
