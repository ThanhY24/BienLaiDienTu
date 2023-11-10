<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceiptModel;
use App\Models\NotificationModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class OrganizationController extends Controller
{
    public function showFormCreateDepartment(){
        return view("pages.Organization.CreateDepartmentPage");
    }
    public function createDepartment(Request $request){
        $dataDepartment = $request->all();
        if(User::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'tax_id' => $request->input('tax_id'),
            'address' => $request->input('address'),
            'link_services' => $request->input('link_services'),
            'link_lookup' => $request->input('link_lookup'),
            'username' => $request->input('username'),
            'password_admin' => $request->input('password'),
            'password' => Hash::make($request->input('password')),
            'username_services' => $request->input('username_services'),
            'password_services' => $request->input('password_services'),
            'role' => "PB",
            'parent_id' => Auth::id(),
            'status' => 1,
        ])){
            return redirect('/department/create')->with('message', 'Tạo phòng ban thành công!')->with('type', 'OK');
        }else{
            return redirect('/department/create')->with('message', 'Có lỗi khi tạo phòng ban.')->with('type', 'ERR');
        }
    }
    public function listDepartment(){
        $listDepartment = User::where("parent_id", "=", Auth::id())->get();
        return view("pages.Organization.ListDepartmentPage")->with("listDepartment", $listDepartment);
    }
    public function showRevenueDepartment(){
        $dataDepartment = User::where("parent_id", "=", Auth::id())->get();
        return view("pages.Organization.RevenueByDepartmentPage")
        ->with("dataDepartment", $dataDepartment)
        ->with("listRevenueDepartment",[])
        ->with("dataListReceipt", [])
        ->with("dataSearch",["idDepartment"=>null]);
    }
    public function revenueDepartment(Request $request){
        $dataDepartment = User::where("parent_id", "=", Auth::id())->get();
        $idDepartment = $request->input(["idDepartment"]);
        $dateFrom = $request->input(["dateFrom"]);
        $dateTo = $request->input(["dateTo"]);
        $dateTo = date('Y-m-d', strtotime($dateTo. ' + 1 days')); 
        if($idDepartment != null){
            $type1 = ReceiptModel::where('type', 1)
            ->where('user_id', $idDepartment)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();
            $type234 = ReceiptModel::whereIn('type', [2, 3, 4])
                ->where('user_id', $idDepartment)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count();
            $type5 = ReceiptModel::where('type', 5)
                ->where('user_id', $idDepartment)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count();
            $dataTypeReceipt = [
                'Type1' => $type1,
                'Type234' => $type234,
                'Type5' => $type5,
            ];
            $dataListReceipt = ReceiptModel::where('user_id', $idDepartment)->whereBetween('created_at', [$dateFrom, $dateTo])->get();
            return view("pages.Organization.RevenueByDepartmentPage")
                    ->with("dataDepartment", $dataDepartment)
                    ->with("dataTypeReceipt", $dataTypeReceipt)
                    ->with("dataListReceipt", $dataListReceipt)
                    ->with("dataSearch", $request->all());
        }
    }
}
