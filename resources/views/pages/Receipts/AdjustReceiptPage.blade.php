@extends('main')
@section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Biên Lai</h2>
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
                <form
                    action="/receipt/adjust"
                    method="post"
                    class="card"
                >
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Điều chỉnh biên lai</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Loại điều chỉnh</label>
                                    <select class="form-select" name="type">
                                        <option value="2">Điều chỉnh tăng</option>
                                        <option value="3">Điều chỉnh giảm</option>
                                        <option value="4">Điều chỉnh thông tin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Mẫu số (Pattern)</label>
                                    <select class="form-select" name="pattern" id="feeSelect">
                                        @foreach($dataPattern as $key => $pattern)
                                        <option value="{{$pattern['pattern']}}">{{$pattern['pattern']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Ký hiệu (Serial)</label>
                                    <select class="form-select" name="serial" id="feeSelect">
                                        @foreach($dataSerial as $key => $serial)
                                        <option value="{{$serial['serial']}}">{{$serial['serial']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Mã tra cứu (Fkey)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Mã tự sinh khi tạo biên lai"
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Mã khách hàng</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mã khách hàng"
                                        value="{{$dataArrayResponse['Content']['CusCode']}}"
                                        name="customer_id"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Tên khách hàng</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tên khách hàng"
                                        value="{{$dataArrayResponse['Content']['CusName']}}"
                                        name="customer_name"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Mã số thuế</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập MST khách hàng"
                                        name="customer_tax_id"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập địa chỉ khách hàng"
                                        name="customer_address"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Người phát hành</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="publisher"
                                        value="{{$dataArrayResponse['Content']['ComName']}}"
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Tên phí, lệ phí</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tên phí, lệ phí"
                                        value="{{$dataArrayResponse['Content']['Products']['Product']['ProdName']}}"
                                        name="fee_name"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Mức phí, lệ phí</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Chọn phí, lệ phí trước"
                                        value="{{number_format($dataArrayResponse['Content']['Products']['Product']['ProdPrice'])}}"
                                        id="fee-cost"
                                        name="fee_cost"
                                    />
                                    <input
                                        type="hidden"
                                        value="{{$fkey}}"
                                        name="fkey"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Số lượng</label>
                                    <input
                                        type="number"
                                        min="1"
                                        max="1000"
                                        class="form-control"
                                        name="quantity"
                                        id="quantity"
                                        value="{{$dataArrayResponse['Content']['Products']['Product']['ProdQuantity']}}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Thành tiền</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0 VND"
                                        id="fee-total"
                                        value="{{number_format($dataArrayResponse['Content']['Products']['Product']['ProdPrice']*$dataArrayResponse['Content']['Products']['Product']['ProdQuantity'])}}"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Phương thức thanh toán</label>
                                    <select class="form-select" name="payment_method">
                                        <option value="TM">Tiền mặt</option>
                                        <option value="CK">Chuyển khoản</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="/receipt" type="submit" class="btn btn-warning">
                                Quay Lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Xác Nhận
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function formatCurrency(price) {
        const formattedPrice = new Intl.NumberFormat('en-US', ).format(price);
        return formattedPrice;
    }
    function unformatCurrency(formattedPrice) {
        const unformattedPrice = parseFloat(formattedPrice.replace(/,/g, ''));
        console.log(unformattedPrice);
        return unformattedPrice;
    }
    function calFeeCost(){
        const feeCost = unformatCurrency(document.getElementById("fee-cost").value);
        const quantity = unformatCurrency(document.getElementById("quantity").value);
        const total = feeCost * quantity;
        console.log(feeCost);
        console.log(quantity);
        console.log(total);
        document.getElementById("fee-cost").value = formatCurrency(feeCost);
        document.getElementById("quantity").value = formatCurrency(quantity);
        document.getElementById("fee-total").value = formatCurrency(total);
    }
    document.getElementById("quantity").addEventListener("input", function() {
        calFeeCost();
    });
    document.getElementById("fee-cost").addEventListener("input", function() {
        calFeeCost();
    });
</script>
@endsection
