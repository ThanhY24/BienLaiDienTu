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
                    action="/receipt/create"
                    method="post"
                    class="card"
                >
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Thêm biên lai</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Mẫu số (Pattern)</label>
                                    <select class="form-select" name="pattern">
                                        @foreach($dataPattern as $key => $pattern)
                                        <option value="{{$pattern['pattern']}}">{{$pattern['pattern']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Ký hiệu (Serial)</label>
                                    <select class="form-select" name="serial">
                                        @foreach($dataSerial as $key => $serial)
                                        <option value="{{$serial['serial']}}">{{$serial['serial']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
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
                                        @if(Auth::check() && isset(auth()->user()->name))
                                            value="{{ auth()->user()->name }}"
                                        @endif
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Chọn phí, lệ phí</label>
                                    <select class="form-select" name="fee_id" id="feeSelect" 
                                        onChange="calFeeCost()">
                                        @foreach($dataFee as $key => $fee)
                                        <option value="{{$fee['id']}}" data-fee-price="{{$fee['fee_cost']}}">{{$fee['fee_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Mức phí, lệ phí</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Chọn phí, lệ phí trước"
                                        id="fee-cost"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-3">
                                    <label class="form-label">Số lượng</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="1"
                                        max="1000"
                                        value="1"
                                        name="quantity"
                                        id="quantity"
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
        const feeSelect = document.getElementById("feeSelect");
        const quantity = document.getElementById("quantity");
        const priceInput = document.querySelector('input[name="price"]');
        let feePrice = 0;
        const selectedOption = feeSelect.options[feeSelect.selectedIndex];
        feePrice = selectedOption.getAttribute("data-fee-price");
        document.getElementById("fee-total").value = formatCurrency(unformatCurrency(feePrice) * unformatCurrency(document.getElementById("quantity").value));
        document.getElementById("fee-cost").value = formatCurrency(feePrice);
    }
    document.getElementById("quantity").addEventListener("input", function() {
        document.getElementById("quantity").value = formatCurrency(unformatCurrency(document.getElementById("quantity").value));
        calFeeCost();
    });
</script>
@endsection
