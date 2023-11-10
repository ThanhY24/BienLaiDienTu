@extends('main')
@section('main_content')
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
            <div class="col-12">
                <form
                    action="/department/create"
                    method="POST"
                    class="card"
                >
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Tạo mới phòng ban</h4>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-title">Thông báo</h4>
                                <div class="text-secondary">{{ session('message') }}</div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên phòng ban</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập họ và tên"
                                        name="name"
                                    />
                                    
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập số điện thoại"
                                        name="phone"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã số thuế</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mã số thuế"
                                        name="tax_id"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập địa chỉ"
                                        name="address"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Đường dẫn quản trị hóa đơn</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập đường dẫn quản trị hóa"
                                        name="link_services"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Đường dẫn tra cứu hóa đơn</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập đường dẫn tra cứu hóa đơn"
                                        name="link_lookup"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Tài khoản quản trị hóa đơn</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tài khoản quản trị hóa đơn"
                                        name="username"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu của tài khoản quản trị hóa đơn</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu của tài khoản quản trị hóa đơn"
                                        name="password"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Tài khoản services</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tài khoản services"
                                        name="username_services"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu của tài khoản services</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu của tài khoản services"
                                        name="password_services"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="#" type="submit" class="btn btn-success">
                                Quay Lại
                            </a>
                            <button type="submit" class="btn btn-danger">
                                Xác Nhận
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
