@extends('main')
@section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Thông tin người dùng</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form
                    action="/user/update"
                    method="POST"
                    class="card"
                >
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Cập nhật thông tin người dùng</h4>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-title">Thông báo</h4>
                                <div class="text-secondary">Cập nhật thông tin người dùng thành công</div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập họ và tên"
                                        name="name"
                                        @if($dataUser)
                                            value="{{$dataUser->name}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->phone}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->tax_id}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->address}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->link_services}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->link_lookup}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->username}}"
                                        @endif
                                        disabled
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
                                        @if($dataUser)
                                            value="{{$dataUser->username_services}}"
                                        @endif
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
                                        @if($dataUser)
                                            value="{{$dataUser->password_services}}"
                                        @endif
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Ký hiệu hóa đơn (Pattern)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập ký hiệu hóa đơn"
                                        name="pattern"
                                        @if($dataUser)
                                            value="{{$dataUser->pattern}}"
                                        @endif
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Mẫu số hóa đơn (Serial)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mẫu số hóa đơn"
                                        name="serial"
                                        @if($dataUser)
                                            value="{{$dataUser->serial}}"
                                        @endif
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
