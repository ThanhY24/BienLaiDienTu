<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ReceiptModel;
use App\Models\FeeModel;
use App\Models\User;
use App\Models\PatternModel;
use App\Models\SerialModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ReceiptController extends Controller
{
    // Type 1 là biên lai gốc
    // Type 2, 3, 4 là biên lai điều chỉnh
    // Type 5 là biên lai thay thế
    public function index(Request $request){
        $today = Carbon::now()->format('Y-m-d');
        $dataReceipt = ReceiptModel::where("user_id", "=", Auth::id())
        ->whereDate('created_at', $today)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('pages.Receipts.ListReceiptPage')->with("dataReceipt", $dataReceipt);
    }
    public function showCreateReceipt(){
        $dataFee = FeeModel::where("user_id", "=", Auth::id())->get();
        $dataPattern = PatternModel::where("tbl_pattern.user_id", Auth::id())->get();
        $dataSerial = SerialModel::select('tbl_serial.serial', 'tbl_pattern.pattern', 'tbl_serial.created_at')
        ->where("tbl_serial.user_id", Auth::id())
        ->join('tbl_pattern', 'tbl_serial.pattern_id', '=', 'tbl_pattern.id')
        ->get();
        return view('pages.Receipts.CreateReceiptPage')->with('dataFee',$dataFee)->with("dataPattern", $dataPattern)->with("dataSerial", $dataSerial);
    }
    public function createReceipt(Request $request){
        $dataReceipt = $request->all();
        $fee_name = FeeModel::find($dataReceipt["fee_id"])->fee_name;
        $fee_cost = FeeModel::find($dataReceipt["fee_id"])->fee_cost;
        $fee_unit = FeeModel::find($dataReceipt["fee_id"])->fee_unit;
        $pattern = $dataReceipt["pattern"];
        $serial = $dataReceipt["serial"];
        $fkey = createFkey();
        $dataReceipt['fkey'] = $fkey;
        $dataReceipt['publisher'] = Auth::user()->name;
        $dataReceipt['fee_name'] = $fee_name;
        $dataReceipt['fee_cost'] = $fee_cost;
        $dataReceipt['amount'] = $fee_cost * $dataReceipt['quantity'];
        $dataReceipt['vat'] = 0;
        $dataReceipt['vat_amout'] = $fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat'];
        $dataReceipt['total'] = ($fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat']) + ($fee_cost * $dataReceipt['quantity']);
        $dataReceipt['receipt_status'] = 1;
        $dataReceipt['publish_date'] = getToDay();
        $dataReceipt['type'] = "1";
        $dataReceipt['user_id'] = Auth::id();
        print_r($dataReceipt);
        $amountInWords = numberToWords($dataReceipt['total']). " Đồng";
        $servicesLink = Auth::user()->link_services."/publishservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $adminUser = Auth::user()->username ;
        $adminPass = Auth::user()->password_admin;
        $toDay = getToday();
        $dataxmlInv = <<<XML
        <Invoices> 
            <Inv>
            <key>$fkey</key>
            <Invoice>
                    <CusCode>{$dataReceipt["customer_id"]}</CusCode>
                    <ArisingDate></ArisingDate>
                    <CusName>{$dataReceipt["customer_name"]}</CusName>
                    <Total>{$dataReceipt['total']}</Total>
                    <Amount>{$dataReceipt['total']}</Amount>
                    <AmountInWords>{$amountInWords}</AmountInWords>
                    <VATRate>{$dataReceipt['vat']}</VATRate>
                    <VATAmount>{$dataReceipt['vat_amout']}</VATAmount>
                    <CusAddress></CusAddress>
                    <PaymentMethod>{$dataReceipt['payment_method']}</PaymentMethod>
                    <Extra>{$dataReceipt['fee_name']}</Extra>
                    <Products>
                        <Product>
                            <Code></Code>
                            <ProdName>{$dataReceipt['fee_name']}</ProdName>
                            <ProdUnit>{$fee_unit}</ProdUnit>
                            <ProdQuantity>{$dataReceipt['quantity']}</ProdQuantity>
                            <ProdPrice>{$dataReceipt['fee_cost']}</ProdPrice>
                            <Total>{$dataReceipt['fee_cost']}</Total>
                            <Amount>{$dataReceipt['fee_cost']}</Amount>
                        </Product>
                    </Products>
            </Invoice>
            </Inv>
        </Invoices>
        XML;
        $dataxmlInv = '<![CDATA['.$dataxmlInv.']]>';
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <ImportAndPublishInv xmlns="http://tempuri.org/">
            <Account>$adminUser</Account>
            <ACpass>$adminPass</ACpass>
            <xmlInvData>$dataxmlInv</xmlInvData>
            <username>$servicesUser</username>
            <password>$servicesPass</password>
            <pattern>$pattern</pattern>
            <serial>$serial</serial>
            <convert>0</convert>
            </ImportAndPublishInv>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        $no = getNoFromResponseVNPT($responseVNPT, 'ImportAndPublishInvResult');
        if($no == null){
            $no = getNoFromResponseVNPTNew($responseVNPT, 'ImportAndPublishInvResult');
        }
        if($no == null){
            $Err = getERRFromVNPT($responseVNPT, 'ImportAndPublishInvResult');
            switch ($Err) {
                case 1:
                    return redirect("/receipt/create")->with('message', 'Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng.')->with('type', 'ERR');
                    break;
                case 3:
                    return redirect("/receipt/create")->with('message', 'Dữ liệu xml đầu vào không đúng quy định.')->with('type', 'ERR');
                    break;
                case 5:
                    return redirect("/receipt/create")->with('message', 'Không phát hành được biên lai.')->with('type', 'ERR');
                    break;
                case 7:
                    return redirect("/receipt/create")->with('message', 'User name không phù hợp, không tìm thấy company tương ứng cho user.')->with('type', 'ERR');
                    break;
                case 20:
                    return redirect("/receipt/create")->with('message', 'Pattern và serial không phù hợp, hoặc không tồn tại biên lai đã đăng kí có sử dụng Pattern và serial truyền vào.')->with('type', 'ERR');
                    break;
                default:
                return redirect("/receipt/create")->with('message', 'Có lỗi khi tạo biên lai.')->with('type', 'ERR');
                    break;
            }
        }else{
            $dataReceipt['no'] = $no;
            if(ReceiptModel::create($dataReceipt)){
                return redirect("/receipt")->with('message', 'Thêm biên lai số '.$no.' thành công. Mã tra cứu là: '.$dataReceipt["fkey"])->with('type', 'OK');
            }else{
                return redirect("/receipt/create")->with('message', 'Có lỗi khi thêm biên lai.')->with('type', 'ERR');
            }
        }
    }
    public function searchReceipt(Request $request){
        $dataSearch = $request->all();
        $validator = Validator::make($request->all(), [
            'date_start' => 'required|date',
            'date_end' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect("/receipt")->with('message', 'Ngày tháng năm không hợp lệ')->with('type', 'ERR');
        }elseif($dataSearch["date_start"] > $dataSearch["date_end"]){
            return redirect("/receipt")->with('message', 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc')->with('type', 'ERR');
        }
        if ($request->has('date_start') && $request->has('date_end')) {
            $dateStart = $dataSearch["date_start"];
            $dateEnd = $dataSearch["date_end"];
            $dataReceipt = ReceiptModel::where("user_id", Auth::id())
            ->whereDate('created_at', '>=', $dateStart)
            ->whereDate('created_at', '<=', $dateEnd)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('pages.Receipts.ListReceiptPage', compact('dataReceipt', 'dateStart', 'dateEnd'));
        } else {
            $dataReceipt = ReceiptModel::where("user_id", "=", Auth::id())->get();
            return redirect("/receipt")->with('message', 'Ngày tháng năm không được để trống.')->with('type', 'ERR');
        }
    }
    public function getDataReceipt(string $fkey_receipt){
        $servicesLink = Auth::user()->link_services."/businessservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <GetInvbyFkey xmlns="http://tempuri.org/">
            <fkey>{$fkey_receipt}</fkey>
            <username>{$servicesUser}</username>
            <pass>{$servicesPass}</pass>
            </GetInvbyFkey>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        $dataResponse = getDataFromResponseVNPT($responseVNPT, "GetInvbyFkeyResult");
        $dataArrayResponse = XMLToArray($dataResponse);
        return response()->json($dataArrayResponse);
    }
    public function showAdjustReceipt(string $fkey_receipt){
        $servicesLink = Auth::user()->link_services."/businessservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <GetInvbyFkey xmlns="http://tempuri.org/">
            <fkey>{$fkey_receipt}</fkey>
            <username>{$servicesUser}</username>
            <pass>{$servicesPass}</pass>
            </GetInvbyFkey>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        $dataResponse = getDataFromResponseVNPT($responseVNPT, "GetInvbyFkeyResult");
        $dataArrayResponse = XMLToArray($dataResponse);
        if($dataArrayResponse){
            $dataFee = FeeModel::where("user_id", "=", Auth::id())->get();
            $dataPattern = PatternModel::where("tbl_pattern.user_id", Auth::id())->get();
            $dataSerial = SerialModel::select('tbl_serial.serial', 'tbl_pattern.pattern', 'tbl_serial.created_at')
            ->where("tbl_serial.user_id", Auth::id())
            ->join('tbl_pattern', 'tbl_serial.pattern_id', '=', 'tbl_pattern.id')
            ->get();
            return view("pages.Receipts.AdjustReceiptPage")
            ->with("dataArrayResponse", $dataArrayResponse)
            ->with('dataFee',$dataFee)
            ->with('fkey',$fkey_receipt)->with("dataPattern", $dataPattern)->with("dataSerial", $dataSerial);
        }else{
            return redirect("/receipt")
            ->with('message', 'Mã tra cứu không tồn tại.')
            ->with('type', 'ERR');
        }
    }
    public function adjustReceipt(Request $request){
        $dataReceipt = $request->all();
        $fkeyOld = $dataReceipt["fkey"];
        $noOld = ReceiptModel::where("fkey", "=", $fkeyOld)->first()["no"];
        unset($dataReceipt["fkey"]);
        $fee_name = $dataReceipt["fee_name"];
        $fee_cost = unformatCurrency($dataReceipt["fee_cost"]);
        $fee_unit = "VND";
        $pattern = $dataReceipt["pattern"];
        $serial = $dataReceipt["serial"];
        $fkey = createFkey();
        $dataReceipt['fkey'] = $fkey;
        $dataReceipt['publisher'] = Auth::user()->name;
        $dataReceipt['fee_name'] = $fee_name;
        $dataReceipt['fee_cost'] = $fee_cost;
        $dataReceipt['amount'] = $fee_cost * $dataReceipt['quantity'];
        $dataReceipt['vat'] = 0;
        $dataReceipt['vat_amout'] = $fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat'];
        $dataReceipt['total'] = ($fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat']) + ($fee_cost * $dataReceipt['quantity']);
        $dataReceipt['receipt_status'] = 1;
        $dataReceipt['publish_date'] = getToDay();
        $dataReceipt['user_id'] = Auth::id();

        $amountInWords = numberToWords($dataReceipt['total']). " Đồng";
        
        $servicesLink = Auth::user()->link_services."/businessservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $adminUser = Auth::user()->username ;
        $adminPass = Auth::user()->password_admin;
        $toDay = getToday();
        $dataxmlInv = <<<XML
        <AdjustInv>
            <key>{$fkey}</key >
            <CusCode>{$dataReceipt['customer_id']}</CusCode>
            <CusName>{$dataReceipt['customer_name']}</CusName>
            <CusAddress>{$dataReceipt['customer_address']}</CusAddress>
            <CusPhone></CusPhone>
            <CusTaxCode>{$dataReceipt['customer_tax_id']}</CusTaxCode>
            <PaymentMethod>{$dataReceipt['payment_method']}</PaymentMethod>
            <KindOfService></KindOfService>
            <Type>{$dataReceipt['type']}</Type>
            <Products>
                <Product>
                    <Code></Code>
                    <ProdName>{$dataReceipt['fee_name']}</ProdName>
                    <ProdUnit>{$fee_unit}</ProdUnit>
                    <ProdQuantity>{$dataReceipt['quantity']}</ProdQuantity>
                    <ProdPrice>{$dataReceipt['fee_cost']}</ProdPrice>
                    <Total>{$dataReceipt['fee_cost']}</Total>
                    <Amount>{$dataReceipt['fee_cost']}</Amount>
                </Product>
            </Products>
            <Total>{$dataReceipt['total']}</Total>
            <Amount>{$dataReceipt['total']}</Amount>
            <AmountInWords>{$amountInWords}</AmountInWords>
            <VATRate>{$dataReceipt['vat']}</VATRate>
            <VATAmount>{$dataReceipt['vat_amout']}</VATAmount>
            <Extra>{$dataReceipt['fee_name']}</Extra>
        </AdjustInv>
        XML;
        $dataxmlInv = '<![CDATA['.$dataxmlInv.']]>';
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <AdjustInvoice xmlns="http://tempuri.org/">
            <Account>{$adminUser}</Account>
            <ACpass>{$adminPass}</ACpass>
            <xmlInvData>{$dataxmlInv}</xmlInvData>
            <username>{$servicesUser}</username>
            <pass>{$servicesPass}</pass>
            <fkey>{$fkeyOld}</fkey>
            <AttachFile>10</AttachFile>
            <convert>0</convert>
            </AdjustInvoice>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        print_r($responseVNPT);
        $no = getNoFromResponseVNPT($responseVNPT, 'AdjustInvoiceResult');
        // if($no == null){
        //     $no = getNoFromResponseVNPTNew($responseVNPT, 'AdjustInvoiceResult');
        // }
        if($no == null){
            $Err = getERRFromVNPT($responseVNPT, 'AdjustInvoiceResult');
            switch ($Err) {
                case 1:
                    return redirect("/receipt/create")->with('message', 'Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng.')->with('type', 'ERR');
                    break;
                case 2:
                    return redirect("/receipt/create")->with('message', 'Biên lai cần điều chỉnh không tồn tại.')->with('type', 'ERR');
                    break;
                case 3:
                    return redirect("/receipt/create")->with('message', 'Dữ liệu xml đầu vào không đúng quy định.')->with('type', 'ERR');
                    break;
                case 5:
                    return redirect("/receipt/create")->with('message', 'Không phát hành được biên lai.')->with('type', 'ERR');
                    break;
                case 6:
                    return redirect("/receipt/create")->with('message', 'Dải biên lai cũ đã hết.')->with('type', 'ERR');
                    break;
                case 7:
                    return redirect("/receipt/create")->with('message', 'User name không phù hợp, không tìm thấy company tương ứng cho user.')->with('type', 'ERR');
                    break;
                case 8:
                    return redirect("/receipt/create")->with('message', 'Biên lai cần điều chỉnh đã bị thay thế. Không thể điều chỉnh được nữa.')->with('type', 'ERR');
                    break;
                case 9:
                    return redirect("/receipt/create")->with('message', 'Trạng thái biên lai không được điều chỉnh.')->with('type', 'ERR');
                    break;
                default:
                    return redirect("/receipt/create")->with('message', 'Có lỗi khi tạo biên lai.')->with('type', 'ERR');
                    break;
            }
        }else{
            $dataReceipt['no'] = $no;
            if(ReceiptModel::create($dataReceipt)){
                $dataReceipt = ReceiptModel::where("fkey", $fkey)->first();
                if ($dataReceipt) {
                    $currentNote = $dataReceipt->note;
                    $dataReceipt->update(['note' => $currentNote . 'Điều chỉnh biên lai số ' . $noOld]);
                }
                return redirect("/receipt")->with('message', 'Tạo biên lai điều chỉnh số '.$no.' thành công. Mã tra cứu là: '.$dataReceipt["fkey"])->with('type', 'OK');
            }else{
                return redirect("/receipt/create")->with('message', 'Có lỗi khi tạo biên lai điều chỉnh.')->with('type', 'ERR');
            }
        }
    }
    public function showReplaceReceipt(string $fkey_receipt){
        $servicesLink = Auth::user()->link_services."/businessservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <GetInvbyFkey xmlns="http://tempuri.org/">
            <fkey>{$fkey_receipt}</fkey>
            <username>{$servicesUser}</username>
            <pass>{$servicesPass}</pass>
            </GetInvbyFkey>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        $dataResponse = getDataFromResponseVNPT($responseVNPT, "GetInvbyFkeyResult");
        $dataArrayResponse = XMLToArray($dataResponse);
        if($dataArrayResponse){
            $dataFee = FeeModel::where("user_id", "=", Auth::id())->get();
            $dataPattern = PatternModel::where("tbl_pattern.user_id", Auth::id())->get();
            $dataSerial = SerialModel::select('tbl_serial.serial', 'tbl_pattern.pattern', 'tbl_serial.created_at')
            ->where("tbl_serial.user_id", Auth::id())
            ->join('tbl_pattern', 'tbl_serial.pattern_id', '=', 'tbl_pattern.id')
            ->get();
            return view("pages.Receipts.ReplaceReceigtPage")
            ->with("dataArrayResponse", $dataArrayResponse)
            ->with('dataFee',$dataFee)
            ->with('fkey',$fkey_receipt)->with("dataPattern", $dataPattern)->with("dataSerial", $dataSerial);
        }else{
            return redirect("/receipt")
            ->with('message', 'Mã tra cứu không tồn tại.')
            ->with('type', 'ERR');
        }
    }
    public function replaceReceipt(Request $request){
        $dataReceipt = $request->all();
        $fkeyOld = $dataReceipt["fkey"];
        $noOld = ReceiptModel::where("fkey", "=", $fkeyOld)->first()["no"];
        unset($dataReceipt["fkey"]);
        $fee_name = $dataReceipt["fee_name"];
        $fee_cost = unformatCurrency($dataReceipt["fee_cost"]);
        $fee_unit = "VND";
        $pattern = $dataReceipt["pattern"];
        $serial = $dataReceipt["serial"];
        $fkey = createFkey();
        $dataReceipt['fkey'] = $fkey;
        $dataReceipt['publisher'] = Auth::user()->name;
        $dataReceipt['fee_name'] = $fee_name;
        $dataReceipt['fee_cost'] = $fee_cost;
        $dataReceipt['amount'] = $fee_cost * $dataReceipt['quantity'];
        $dataReceipt['vat'] = 0;
        $dataReceipt['vat_amout'] = $fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat'];
        $dataReceipt['total'] = ($fee_cost * $dataReceipt['quantity'] * $dataReceipt['vat']) + ($fee_cost * $dataReceipt['quantity']);
        $dataReceipt['receipt_status'] = 1;
        $dataReceipt['type'] = "5";
        $dataReceipt['publish_date'] = getToDay();
        $dataReceipt['user_id'] = Auth::id();

        $amountInWords = numberToWords($dataReceipt['total']). " Đồng";
        
        $servicesLink = Auth::user()->link_services."/businessservice.asmx";
        $servicesUser = Auth::user()->username_services;
        $servicesPass = Auth::user()->password_services;
        $adminUser = Auth::user()->username ;
        $adminPass = Auth::user()->password_admin;
        $toDay = getToday();
        $dataxmlInv = <<<XML
        <ReplaceInv>
            <key>{$fkey}</key >
            <CusCode>{$dataReceipt['customer_id']}</CusCode>
            <CusName>{$dataReceipt['customer_name']}</CusName>
            <CusAddress>{$dataReceipt['customer_address']}</CusAddress>
            <CusPhone></CusPhone>
            <CusTaxCode>{$dataReceipt['customer_tax_id']}</CusTaxCode>
            <PaymentMethod>{$dataReceipt['payment_method']}</PaymentMethod>
            <KindOfService></KindOfService>
            <Products>
                <Product>
                    <Code></Code>
                    <ProdName>{$dataReceipt['fee_name']}</ProdName>
                    <ProdUnit>{$fee_unit}</ProdUnit>
                    <ProdQuantity>{$dataReceipt['quantity']}</ProdQuantity>
                    <ProdPrice>{$dataReceipt['fee_cost']}</ProdPrice>
                    <Total>{$dataReceipt['fee_cost']}</Total>
                    <Amount>{$dataReceipt['fee_cost']}</Amount>
                </Product>
            </Products>
            <Total>{$dataReceipt['total']}</Total>
            <Amount>{$dataReceipt['total']}</Amount>
            <AmountInWords>{$amountInWords}</AmountInWords>
            <VATRate>{$dataReceipt['vat']}</VATRate>
            <VATAmount>{$dataReceipt['vat_amout']}</VATAmount>
            <Extra>{$dataReceipt['fee_name']}</Extra>
        </ReplaceInv>
        XML;
        $dataxmlInv = '<![CDATA['.$dataxmlInv.']]>';
        $dataXML = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
            <ReplaceInvoie xmlns="http://tempuri.org/">
            <Account>{$adminUser}</Account>
            <ACpass>{$adminPass}</ACpass>
            <xmlInvData>{$dataxmlInv}</xmlInvData>
            <username>{$servicesUser}</username>
            <pass>{$servicesPass}</pass>
            <fkey>{$fkeyOld}</fkey>
            <AttachFile>10</AttachFile>
            <convert>0</convert>
            </ReplaceInvoie>
        </soap12:Body>
        </soap12:Envelope>
        XML;
        $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
        print_r($responseVNPT);
        $no = getNoFromResponseVNPT($responseVNPT, 'ReplaceInvoieResult');
        if($no == null){
            $no = getNoFromResponseVNPTNew($responseVNPT, 'ReplaceInvoieResult');
        }
        if($no == null){
            $Err = getERRFromVNPT($responseVNPT, 'ReplaceInvoieResult');
            switch ($Err) {
                case 1:
                    return redirect("/receipt/create")->with('message', 'Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng.')->with('type', 'ERR');
                    break;
                case 2:
                    return redirect("/receipt/create")->with('message', 'Biên lai cần điều chỉnh không tồn tại.')->with('type', 'ERR');
                    break;
                case 3:
                    return redirect("/receipt/create")->with('message', 'Dữ liệu xml đầu vào không đúng quy định.')->with('type', 'ERR');
                    break;
                case 5:
                    return redirect("/receipt/create")->with('message', 'Không phát hành được biên lai.')->with('type', 'ERR');
                    break;
                case 6:
                    return redirect("/receipt/create")->with('message', 'Dải biên lai cũ đã hết.')->with('type', 'ERR');
                    break;
                case 7:
                    return redirect("/receipt/create")->with('message', 'User name không phù hợp, không tìm thấy company tương ứng cho user.')->with('type', 'ERR');
                    break;
                case 8:
                    return redirect("/receipt/create")->with('message', 'Biên lai cần điều chỉnh đã bị thay thế. Không thể điều chỉnh được nữa.')->with('type', 'ERR');
                    break;
                case 9:
                    return redirect("/receipt/create")->with('message', 'Trạng thái biên lai không được điều chỉnh.')->with('type', 'ERR');
                    break;
                default:
                    return redirect("/receipt/create")->with('message', 'Có lỗi khi tạo biên lai.')->with('type', 'ERR');
                    break;
            }
        }else{
            $dataReceipt['no'] = $no;
            if(ReceiptModel::create($dataReceipt)){
                $dataReceipt = ReceiptModel::where("fkey", $fkey)->first();
                if ($dataReceipt) {
                    $currentNote = $dataReceipt->note;
                    $dataReceipt->update(['note' => $currentNote . 'Thay thế biên lai số ' . $noOld]);
                }
                return redirect("/receipt")->with('message', 'Tạo biên lai thay thế số '.$no.' thành công. Mã tra cứu là: '.$dataReceipt["fkey"])->with('type', 'OK');
            }else{
                return redirect("/receipt/create")->with('message', 'Có lỗi khi tạo biên lai thay thế.')->with('type', 'ERR');
            }
        }
    }
    public function downloadReceipt(Request $request, string $fkey_receipt){
        $UID = $request->input('UID');
        if($UID != null){
            $dataUserByID = User::where("id", $UID)->first();
            if($dataUserByID != null){
                $servicesLink = $dataUserByID["link_services"]."/portalservice.asmx";
                $servicesUser = $dataUserByID["username_services"];
                $servicesPass = $dataUserByID["password_services"];
                $dataXML = <<<XML
                <?xml version="1.0" encoding="utf-8"?>
                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                <soap12:Body>
                    <downloadInvPDFFkeyNoPay xmlns="http://tempuri.org/">
                    <fkey>{$fkey_receipt}</fkey>
                    <userName>{$servicesUser}</userName>
                    <userPass>{$servicesPass}</userPass>
                    </downloadInvPDFFkeyNoPay>
                </soap12:Body>
                </soap12:Envelope>
                XML;
                $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
                $dataResponse = getDataFromResponseVNPT($responseVNPT, "downloadInvPDFFkeyNoPayResponse");
                if (isBase64($dataResponse)) {
                    $dataPDFReceipt = base64_decode($dataResponse);
                    $headers = [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="receipt.pdf"',
                    ];
                    return Response::make($dataPDFReceipt, 200, $headers);
                } else {
                    echo "Fkey không tồn tại vui lòng kiểm tra lại.";
                }
            }else{
                echo "Đường dẫn không hợp lệ.";
            }
            
        }else{
            echo "Đường dẫn không hợp lệ.";
        }
        
    }
    public function lookupReceipt(Request $request, string $fkey_receipt){
        $UID = $request->input('UID');
        if($UID != null){
            $dataUserByID = User::where("id", $UID)->first();
            if($dataUserByID != null){
                $servicesLink = $dataUserByID["link_services"]."/portalservice.asmx";
                $servicesUser = $dataUserByID["username_services"];
                $servicesPass = $dataUserByID["password_services"];
                $dataXML = <<<XML
                <?xml version="1.0" encoding="utf-8"?>
                <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                <soap12:Body>
                    <downloadInvPDFFkeyNoPay xmlns="http://tempuri.org/">
                    <fkey>{$fkey_receipt}</fkey>
                    <userName>{$servicesUser}</userName>
                    <userPass>{$servicesPass}</userPass>
                    </downloadInvPDFFkeyNoPay>
                </soap12:Body>
                </soap12:Envelope>
                XML;
                $responseVNPT = sendDataToVNPT($servicesLink, $dataXML);
                $dataResponse = getDataFromResponseVNPT($responseVNPT, "downloadInvPDFFkeyNoPayResponse");
                if (isBase64($dataResponse)) {
                    $dataPDFReceipt = base64_decode($dataResponse);
                    return view("pages.Receipts.LookupReceipt")->with("dataPDFReceipt", $dataPDFReceipt);
                } else {
                    echo "Fkey không tồn tại vui lòng kiểm tra lại.";
                }
            }else{
                echo "Đường dẫn không hợp lệ.";
            }
        }else{
            echo "Đường dẫn không hợp lệ.";;
        }
    }
}