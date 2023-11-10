@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Quản lý người dùng</h2>
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
            <div class="col-3">
                <form action="{{ url('/admin/user/create') }}" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Thêm người dùng mới</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Tên người dùng</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập họ và tên"
                                        name="name"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Tài khoản</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tài khoản quản trị hóa đơn"
                                        name="username"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Mật khẩu</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu của tài khoản quản trị hóa đơn"
                                        name="password"
                                        required
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
                    <div class="card-header">
                        <h4 class="card-title">Danh sách người dùng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên người dùng</th>
                                        <th>Mã số thuế</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th class="w-20"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($dataUser as $key => $user)
                                    @if ($user['role'] !== "QTV")
                                        <tr>
                                            <td class="text-muted">{{ $key + 1 }}</td>
                                            <td>{{ $user['name'] != NULL ? $user['name'] : "Chưa cập nhật" }}</td>
                                            <td>{{ $user['tax_id'] != NULL ? $user['tax_id'] : "Chưa cập nhật" }}</td>
                                            <td>{{ $user['phone'] != NULL ? $user['phone'] : "Chưa cập nhật" }}</td>
                                            <td>{{ $user['address'] != NULL ? $user['address'] : "Chưa cập nhật" }}</td>
                                            <td>
                                                <a href="/admin/reset-pasword-user/{{$user['id']}}" title="Cấp lại mật khẩu">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                                                    <path d="M15 9h.01"></path>
                                                </svg>
                                                </a>
                                                @if ($user['status'] == 1)
                                                    <a href="/admin/lock-user/{{$user['id']}}" class="text-danger" style="margin-left: 10px;" title="Khóa người dùng">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-open-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M15 11h2a2 2 0 0 1 2 2v2m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h4"></path>
                                                        <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                        <path d="M8 11v-3m.347 -3.631a4 4 0 0 1 7.653 1.631"></path>
                                                        <path d="M3 3l18 18"></path>
                                                    </svg>
                                                    </a>
                                                @else
                                                    <a href="/admin/unlock-user/{{$user['id']}}" class="text-success" style="margin-left: 10px;" title="Mở khóa người dùng">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-open" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                                        <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                        <path d="M8 11v-5a4 4 0 0 1 8 0"></path>
                                                    </svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
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
