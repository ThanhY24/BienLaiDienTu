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
        <link rel="icon" type="image/png" href="https://vnptgroup.vn/wp-content/uploads/2020/06/cropped-logo-vnpt-2.jpg">
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
    <body class="d-flex flex-column">
        <script src="./dist/js/demo-theme.min.js?1684106062"></script>
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark">
                        <img src="{{asset('images/logo.png')}}" height="50" alt=""/>
                    </a>
                </div>
                <div class="card card-md">
                    <div class="card-body">
                        <h2 class="h2 text-center mb-4">Đăng ký</h2>
                        <form method="POST" action="{{ url('/register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Họ và tên</label
                                >
                                <div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập họ và tên của bạn"
                                        name="name"
                                        required
                                    />
                                    <small class="form-hint"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Tài khoản</label
                                >
                                <div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tài khoản quản trị hóa đơn"
                                        name="username"
                                        required
                                    />
                                    <small class="form-hint"></small>
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
                                        placeholder="Nhập mật khẩu của tài khoản quản trị hóa đơn"
                                        name="password"
                                        required
                                    />
                                    <small class="form-hint"></small>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    Xác nhận
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center text-muted mt-3">
                    Bạn có tài khoản?
                    <a href="/login" tabindex="-1">Đăng nhập</a>
                </div>
            </div>
        </div>
        <!-- Libs JS -->
        <!-- Tabler Core -->
        <script src="./dist/js/tabler.min.js?1684106062" defer></script>
        <script src="./dist/js/demo.min.js?1684106062" defer></script>
    </body>
</html>
