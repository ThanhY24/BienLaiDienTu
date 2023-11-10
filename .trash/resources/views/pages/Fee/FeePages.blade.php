@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Quản lý phí, lệ phí</h2>
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
            <div class="col-4">
                <form action="/fee" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Thêm phí, lệ phí mới</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Mã phí, lệ phí</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập không quá 20 ký tự"
                                        name="fee_id"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Tên phí, lệ phí</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập không quá 20 ký tự"
                                        name="fee_name"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Đơn vị tính</label
                                    >
                                    <select class="form-select" name="fee_unit">
                                        <option value="VND">VND</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Mức phí, lệ phí</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập không quá 20 ký tự"
                                        name="fee_cost"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea
                                        class="form-control"
                                        name="fee_des"
                                        rows="3"
                                    ></textarea>
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách phí, lệ phí mới</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã</th>
                                        <th>Tên</th>
                                        <th>Mức phí, lệ phí</th>
                                        <th>Đơn vị tính</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataFee as $key => $fee)
                                    <tr>
                                        <td class="text-muted">{{ $key + 1 }}</td>
                                        <td>{{ $fee['fee_id'] }}</td>
                                        <td>{{ $fee['fee_name'] }}</td>
                                        <td>{{ number_format($fee['fee_cost']) }}</td>
                                        <td>{{ $fee['fee_unit'] }}</td>
                                        <td>
                                            <a href="#">Sửa</a>
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
@endsection
