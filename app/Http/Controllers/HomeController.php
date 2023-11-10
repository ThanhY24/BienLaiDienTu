<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceiptModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == "QTV"){
            return redirect("/admin");
        }
        $today = Carbon::now()->format('Y-m-d');
        // Type 1 là biên lai gốc
        // Type 2, 3, 4 là biên lai điều chỉnh
        // Type 5 là biên lai thay thế
        // Lấy các loại biên lai
        $type1 = ReceiptModel::where('type', 1)->where("user_id", Auth::id())->whereDate('created_at', $today)->count();
        $type2 = ReceiptModel::where('type', 2)->where("user_id", Auth::id())->whereDate('created_at', $today)->count();
        $type3 = ReceiptModel::where('type', 3)->where("user_id", Auth::id())->whereDate('created_at', $today)->count();
        $type4 = ReceiptModel::where('type', 4)->where("user_id", Auth::id())->whereDate('created_at', $today)->count();
        $type5 = ReceiptModel::where('type', 5)->where("user_id", Auth::id())->whereDate('created_at', $today)->count();
        $dataTypeReceipt = [
            'Type1' => $type1,
            'Type234' => $type2 + $type3 + $type4,
            'Type5' => $type5,
        ];
        $dataListReceipt = ReceiptModel::where("user_id", "=", Auth::id())->whereDate('created_at', $today)->get();
        // Lấy danh sách biên lai
        return view('pages.Dasboard.HomePage')
                ->with("dataTypeReceipt", $dataTypeReceipt)
                ->with("dataListReceipt", $dataListReceipt);
    }
}
