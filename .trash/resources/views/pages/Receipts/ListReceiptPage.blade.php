@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Biên lai</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @if(session('message'))
                <div class="alert alert-{ session('type') == 'WAR' ? 'warning' : (session('type') == 'ERR' ? 'danger' : 'success') }}" role="alert">
                <h4 class="alert-title">
                    {{ session('type') == 'WAR' ? 'Cảnh báo' : (session('type') == 'ERR' ? 'Cảnh báo' : 'Thông báo') }}
                </h4>
                    <div class="text-secondary">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="col-3">
                <form action="/receipt/search" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Tìm kiếm biên lai</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Từ ngày</label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        placeholder="Nhập không quá 20 ký tự"
                                        name="date_start"
                                        @if(isset($dateStart) && $dateStart)
                                            value="{{ $dateStart }}"
                                        @endif
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Đến ngày</label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        placeholder="Nhập không quá 20 ký tự"
                                        name="date_end"
                                        @if(isset($dateEnd) && $dateEnd)
                                            value="{{ $dateEnd }}"
                                        @endif
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success">
                                Xác Nhận
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Danh sách biên lai</h4>
                        <a href="/receipt/create" type="submit" class="btn btn-primary">Tạo Biên Lai Mới</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th class="w-1">
                                        <th>Mẫu số</th>
                                        <th>Ký hiệu</th>
                                        <th>Số biên lai</th>
                                        <th>Tên khách hàng</th>
                                        <th>Người phát hành</th>
                                        <th>Ngày phát hành</th>
                                        <th>Ghi chú</th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataReceipt as $key => $receipt)
                                    <tr>
                                        <td class="text-muted">{{$key+1}}</td>
                                        <td class="w-1">
                                            <a class="view-button" data-receipt-fkey="{{ json_encode($receipt) }}"
                                            data-bs-toggle="modal" data-bs-target="#modal-team" style="cursor: pointer;"
                                            >Xem</a>
                                        </td>
                                        <td>{{$receipt["pattern"]}}</td>
                                        <td>{{$receipt["serial"]}}</td>
                                        <td>{{$receipt["no"]}}</td>
                                        <td>{{$receipt["customer_name"]}}</td>
                                        <td>{{$receipt["publisher"]}}</td>
                                        <td>{{$receipt->created_at->format('d/m/Y')}}</td>
                                        <td>
                                        @switch($receipt->type)
                                            @case(1)
                                                Biên lai gốc
                                                @break
                                            @case(2)
                                            @case(3)
                                            @case(4)
                                            @case(5)
                                                {{ $receipt["note"] }}
                                                @break
                                        @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
$(document).ready(function () {
    $('.view-button').click(function () {
        var receiptData = $(this).data('receipt-fkey');
        document.getElementById("btnAdjustReceipt").style.display="none";
        document.getElementById("btnReplaceReceipt").style.display="none";
        document.getElementById("printReceiptBtn").style.display="none";
        $.ajax({
            url: '/receipt/' + receiptData.fkey,
            type: 'GET',
            success: function (data) {
                console.log(data);
                // Tải dữ liệu lên bảng in
                document.getElementById("receipt-name").innerHTML = data.Content.ComName
                document.getElementById("receipt-taxID").innerHTML = "Mã số thuế: "+data.Content.ComTaxCode
                document.getElementById("receipt-fee-name").innerHTML = data.Content.Extra;
                document.getElementById("receipt-cus-name").innerHTML = "<b>Tên khách hàng:</b> "+ data.Content.CusName;
                document.getElementById("receipt-cus-taxID").innerHTML = data.Content.CusTaxCode.length != 0 ? "<b>Mã số thuế:</b> " + data.Content.CusTaxCode : "<b>Mã số thuế:</b>.............................................";
                document.getElementById("receipt-cus-address").innerHTML = data.Content.CusAddress.length != 0 ? "<b>Địa chỉ:</b> " + data.Content.CusAddress : "<b>Địa chỉ:</b>....................................................";
                
                var formattedAmount = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(data.Content.Amount);
                document.getElementById("receipt-amount").innerHTML = "<b>Số tiền:</b> " + formattedAmount;
                document.getElementById("receipt-amount-in-word").innerHTML = "<b>(Viết bằng chữ):</b> "  + data.Content.AmountInWords;document.getElementById("receipt-payment-method").innerHTML = data.Content.Kind_of_Payment == "TM" ? "<b>Hình thức thanh toán:</b> Tiền mặt" : 
                                                      data.Content.Kind_of_Payment == "CK" ? "<b>Hình thức thanh toán:</b> Chuyển khoản" : "";

                
                document.getElementById("receipt-pattern-serial").innerHTML = "<b>Mẫu số:</b> "+data.Content.InvoicePattern +"</br><b>Ký hiệu:</b> "+data.Content.SerialNo

                document.getElementById("btnAdjustReceipt").href = "/receipt/adjust/"+receiptData.fkey;
                document.getElementById("btnReplaceReceipt").href = "/receipt/replace/"+receiptData.fkey;

                // Lấy thẻ chứa QR code
                var qrcodeContainer = document.getElementById("receipt-qrcode");

                // Xóa nội dung cũ của thẻ (nếu có)
                qrcodeContainer.innerHTML = "";

                // Lấy URL gốc (root URL)
                var rootUrl = window.location.origin;

                // Đặt n vào chuỗi receiptData.fkey
                var fullFkey = rootUrl + '/receipt/download/' + receiptData.fkey;
                console.log(fullFkey);
                // Tạo QR code mới và thêm vào thẻ
                var qrcode = new QRCode(qrcodeContainer, {
                    text: fullFkey, // Sử dụng chuỗi có URL gốc và fkey
                    width: 80,
                    height: 80,
                    correctLevel: QRCode.CorrectLevel.L
                });
                // Tạo link
                // document.getElementById("receipt-footer").innerHTML = "Quét mã để tải về biên lai hoặc tra cứu biên lai tại: " + rootUrl + '/receipt/lookup/' + receiptData.fkey
                // Bỏ loading và show giao diện
                document.getElementById("receiptPrintBody").style.display="flex";
                document.getElementById("loadContainerViewReceipt").style.display="none";
                // Hiển thị các nút khi tải dữ liệu xong
                document.getElementById("btnAdjustReceipt").style.display="flex";
                document.getElementById("btnReplaceReceipt").style.display="flex";
                document.getElementById("printReceiptBtn").style.display="flex";

                if(document.getElementById("receipt-fee-name").offsetWidth > 155){
                    document.getElementById("receipt-fee-name").style.border = "none";
                }
                console.log(document.getElementById("receipt-fee-name").offsetWidth);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});
document.getElementById('printReceiptBtn').addEventListener('click', function () {
    window.print();
});
</script>
@endsection
