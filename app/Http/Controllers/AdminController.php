<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceiptModel;
use App\Models\NotificationModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        // Lấy tỷ lệ các loại hóa đơn
        // Type 1 là biên lai gốc
        // Type 2, 3, 4 là biên lai điều chỉnh
        // Type 5 là biên lai thay thế
        $type1 = ReceiptModel::where('type', 1)->whereDate('created_at', $today)->count();
        $type2 = ReceiptModel::where('type', 2)->whereDate('created_at', $today)->count();
        $type3 = ReceiptModel::where('type', 3)->whereDate('created_at', $today)->count();
        $type4 = ReceiptModel::where('type', 4)->whereDate('created_at', $today)->count();
        $type5 = ReceiptModel::where('type', 5)->whereDate('created_at', $today)->count();
        $dataTypeReceipt = [
            'Type1' => $type1,
            'Type234' => $type2 + $type3 + $type4,
            'Type5' => $type5,
        ];
        // Lấy danh sách doanh thu người dùng
        $listUser = User::where('role', '<>', 'QTV')->orWhereNull('role')->get();
        $listRevenue = [];
        foreach ($listUser as $user) {
            $totalAmount = ReceiptModel::where('user_id', $user["id"])->whereDate('created_at', $today)->sum('amount');
            $totalReceipt = ReceiptModel::where('user_id', $user["id"])->whereDate('created_at', $today)->count();
            $item = [$user["name"], $user["tax_id"], $totalReceipt, $totalAmount];
            $listRevenue[] = $item;
        }
        return view("pages.Admin.Dasboard.HomePage")
                ->with("listRevenue", $listRevenue)
                ->with("dataTypeReceipt", $dataTypeReceipt);
    }
    public function listUser()
    {
        $dataUser = User::all();
        return view('pages.Admin.User.UserPage')->with("dataUser", $dataUser);
    }
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if(User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'password_admin' => $request->input('password'),
            'role' => "NPB",
            'status' => 1,
        ])){
            return redirect('/admin/user')->with('message', 'Tạo người dùng thành công!')->with('type', 'OK');
        }else{
            return redirect('/admin/user')->with('message', 'Có lỗi khi tạo người dùng.')->with('type', 'ERR');
        }
    }
}
