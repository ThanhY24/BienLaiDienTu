@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Phòng ban</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @if(session('message'))
                <div class="alert alert-{{ session('type') == 'ERR' ? 'danger' : 'success' }}" role="alert">
                    <h4 class="alert-title">{{ session('type') == 'ERR' ? 'Cảnh báo' : 'Thông báo' }}</h4>
                    <div class="text-secondary">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Danh sách phòng ban</h4>
                        <a href="/department/create" type="submit" class="btn btn-primary">Tạo Phòng Ban</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên phòng ban</th>
                                        <th>Mã số thuế</th>
                                        <th>Số điện thoại</th>
                                        <th>Tài khoản quản trị</th>
                                        <th>Tài khoản services</th>
                                        <th>Ngày tạo</th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listDepartment as $key => $department)
                                    <tr>
                                        <td class="text-muted">{{$key+1}}</td>
                                        <td>{{$department["name"]}}</td>
                                        <td>{{$department["tax_id"]}}</td>
                                        <td>{{$department["phone"]}}</td>
                                        <td>{{$department["username"]}}</td>
                                        <td>{{$department["username_services"]}}</td>
                                        <td>{{$department->created_at->format('d/m/Y')}}</td>
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

                
                                document.getElementById("receipt-pattern-serial").innerHTML = "<b>Mẫu số:</b> "+data.Content.InvoicePattern +"</br><b>Ký hiệu:</b> "+data.Content.SerialNo+"</br><b>Số:</b> "+data.Content.InvoiceNo

                document.getElementById("btnAdjustReceipt").href = "/receipt/adjust/"+receiptData.fkey;
                document.getElementById("btnReplaceReceipt").href = "/receipt/replace/"+receiptData.fkey;

                // Lấy thẻ chứa QR code
                var qrcodeContainer = document.getElementById("receipt-qrcode");

                // Xóa nội dung cũ của thẻ (nếu có)
                qrcodeContainer.innerHTML = "";

                // Lấy URL gốc (root URL)
                var rootUrl = window.location.origin;
                var UID = <?php echo Auth::id();?>
                // Đặt n vào chuỗi receiptData.fkey
                var fullFkey = rootUrl + '/receipt/download/' + receiptData.fkey + "?UID=" + UID;
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
                console.log(document.getElementById("receipt-fee-name").offsetWidth);
                if(document.getElementById("receipt-fee-name").offsetWidth > 170){
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
