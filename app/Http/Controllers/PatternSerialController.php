<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatternModel;
use App\Models\SerialModel;
use Illuminate\Support\Facades\Auth;

class PatternSerialController extends Controller
{
    public function index(){
        $dataPattern = PatternModel::where("tbl_pattern.user_id", Auth::id())->get();
        $dataSerial = SerialModel::select('tbl_serial.serial', 'tbl_pattern.pattern', 'tbl_serial.created_at')
        ->where("tbl_serial.user_id", Auth::id())
        ->join('tbl_pattern', 'tbl_serial.pattern_id', '=', 'tbl_pattern.id')
        ->get();
        return view("pages.PatternSerial.PartternSerialPage")->with("dataPattern", $dataPattern)->with("dataSerial", $dataSerial);
    }
    public function createPattern(Request $request){
        $dateCreatePattern = $request->all();
        if(PatternModel::create([
            "pattern" => $dateCreatePattern["pattern"],
            "user_id" => Auth::id()
        ])){
            return redirect("/pattern-serial")->with('message', 'Tạo mẫu số thành công.')->with('type', 'OK');
        }else{
            return redirect("/pattern-serial")->with('message', 'Có lỗi khi tạo mẫu số.')->with('type', 'ERR');
        }
    }
    public function createSerrial(Request $request){
        $dataCreateSerial = $request->validate([
            'pattern_id' => 'required|exists:tbl_pattern,id',
            'serial' => 'required',
        ]);
        $idPattern = $dataCreateSerial["pattern_id"];
        $serial = $dataCreateSerial["serial"];
        if(SerialModel::create([
            "pattern_id" => $idPattern,
            "serial" => $serial,
            "user_id" => Auth::id(),
        ])){
            return redirect("/pattern-serial")->with('message', 'Tạo ký hiệu thành công.')->with('type', 'OK');
        }else{
            return redirect("/pattern-serial")->with('message', 'Có lỗi khi tạo ký hiệu.')->with('type', 'ERR');
        }
    }
}
