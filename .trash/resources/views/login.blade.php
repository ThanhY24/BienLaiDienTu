<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, viewport-fit=cover"
        />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Biên Lại Điện Tử</title>
        <!-- CSS files -->
        <link href="{{asset('css/tabler.min.css')}}" rel="stylesheet" />
        <link href="{{asset('css/tabler-flags.min.css')}}" rel="stylesheet" />
        <link
            href="{{asset('css/tabler-payments.min.css')}}"
            rel="stylesheet"
        />
        <link href="{{asset('css/tabler-vendors.min.css')}}" rel="stylesheet" />
        <link href="{{asset('css/demo.min.css')}}" rel="stylesheet" />
        <style>
            @import url("https://rsms.me/inter/inter.css");
            :root {
                --tblr-font-sans-serif: "Inter Var", -apple-system,
                    BlinkMacSystemFont, San Francisco, Segoe UI, Roboto,
                    Helvetica Neue, sans-serif;
            }
            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="page-wrapper">
                <div class="col-md-3 m-0 m-auto">
                    <form class="card"  method="POST" action="{{ url('/login') }}">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title m-0 m-auto">Đăng Nhập</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Tài khoản</label
                                >
                                <div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tài khoản"
                                        name="username"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Mật khẩu</label
                                >
                                <div>
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu"
                                        name="password"
                                        required
                                    />
                                    <small class="form-hint">
                                        @if(session('message'))
                                            {{ session('message') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="/register" class="btn btn-sucess">
                                Đăng Ký
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Xác Nhận
                            </button>
                        </div>
                    </form>
                </div>
                <footer class="footer footer-transparent d-print-none">
                    <div class="container-xl">
                        <div
                            class="row text-center align-items-center flex-row-reverse"
                        >
                            <div class="col-lg-auto ms-lg-auto"></div>
                            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item">
                                        Copyright &copy; 2023
                                        <a href="." class="link-secondary"
                                            >VNPT Cần Thơ</a
                                        >. All rights reserved.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
