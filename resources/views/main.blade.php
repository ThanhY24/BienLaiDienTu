<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, viewport-fit=cover"
        />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Biên Lai Điện Tử</title>
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
        <link href="{{asset('css/extends.css')}}" rel="stylesheet" />
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
        <script src="{{asset('/js/demo-theme.min.js')}}"></script>
        <div class="page" >
            <!-- Navbar -->
            <header class="navbar navbar-expand-md d-print-none">
                <div class="container-xl">
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbar-menu"
                        aria-controls="navbar-menu"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1
                        class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"
                    >
                        <a href="">
                            <img
                                src="https://vnpt.com.vn/Media/Images/28082023/logo%20VNPT.png"
                                width="110"
                                height="32"
                                alt="Tabler"
                                class="navbar-brand-image"
                            />
                        </a>
                    </h1>
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="d-none d-md-flex">
                            <div class="nav-item dropdown d-none d-md-flex me-3" >
                                <a href="#"
                                    class="nav-link px-0"
                                    data-bs-toggle="dropdown"
                                    tabindex="-1"
                                    aria-label="Show notifications" >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
                                        />
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                    </svg>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card"
                                >
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Thông báo
                                            </h3>
                                        </div>
                                        <div
                                            class="list-group list-group-flush list-group-hoverable"
                                        >
                                            @foreach($dataNotification as $notification)
                                            @if($notification["user_to"] == Auth::id())
                                            <div class="list-group-item">
                                                <div class="row align-items-center" >
                                                    <div class="col-auto">
                                                        <span
                                                            class="status-dot status-dot-animated bg-success d-block"
                                                        ></span>
                                                    </div>
                                                    <div class="col text-truncate" >
                                                        <div class="d-block text-muted text-truncate mt-n1" >{{$notification["notification_title"]}}</div>
                                                        <p  class="text-body d-block">{{$notification["notification_content"]}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a
                                href="#"
                                class="nav-link d-flex lh-1 text-reset p-0"
                                data-bs-toggle="dropdown"
                                aria-label="Open user menu"
                            >
                                <span
                                    class="avatar avatar-sm"
                                    style="background-image: url('{{asset('/images/9131529.png')}}');box-shadow:unset;"
                                ></span>
                                <div class="d-none d-xl-block ps-2">
                                    @if (Auth::check())
                                    <div>{{ Auth::user()->name }}</div>
                                    @else
                                    <div>Bạn chưa đăng nhập</div>
                                    @endif
                                </div>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                            >
                                <a href="/profile" class="dropdown-item"
                                    >Cấu hình thông tin</a
                                >
                                <a href="/logout" class="dropdown-item"
                                    >Đăng xuất</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <header class="navbar-expand-md">
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="navbar">
                        <div class="container-xl">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{Auth::user()->role == 'QTV' ? '/admin' : '/'}}">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"
                                            >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                                <path
                                                    d="M5 12l-2 0l9 -9l9 9l-2 0"
                                                />
                                                <path
                                                    d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"
                                                />
                                                <path
                                                    d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"
                                                />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Trang chủ
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a
                                        class="nav-link dropdown-toggle"
                                        href="/receipt"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"
                                        role="button"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-receipt"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                ></path>
                                                <path
                                                    d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2"
                                                ></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Biên lai
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a
                                            class="dropdown-item"
                                            href="/receipt"
                                        >
                                            Danh sách biên lai
                                        </a>
                                        <a
                                            class="dropdown-item"
                                            href="/receipt/create"
                                        >
                                            Tạo biên lai mới
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/fee">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-list-details"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                ></path>
                                                <path d="M13 5h8"></path>
                                                <path d="M13 9h5"></path>
                                                <path d="M13 15h8"></path>
                                                <path d="M13 19h5"></path>
                                                <path
                                                    d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"
                                                ></path>
                                                <path
                                                    d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"
                                                ></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Phí, lệ phí
                                        </span>
                                    </a>
                                </li>
                                @if(Auth::user()->role == "QTV")
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/user">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                <path d="M15 19l2 2l4 -4"></path>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Người dùng
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="/pattern-serial">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M15 8l2 0"></path>
                                        <path d="M15 12l2 0"></path>
                                        <path d="M7 16l10 0"></path>
                                        </svg>
                                        <span class="nav-link-title">
                                            Mẫu số/Ký hiệu
                                        </span>
                                    </a>
                                </li>
                                @if(Auth::user()->role == "NPB")
                                <li class="nav-item dropdown">
                                    <a
                                        class="nav-link dropdown-toggle"
                                        href="/receipt"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"
                                        role="button"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-door" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 12v.01"></path>
                                        <path d="M3 21h18"></path>
                                        <path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16"></path>
                                        </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Phòng Ban
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a
                                            class="dropdown-item"
                                            href="/department/revenue"
                                        >
                                            Doanh thu phòng ban
                                        </a>
                                        <a
                                            class="dropdown-item"
                                            href="/department"
                                        >
                                            Danh sách phòng ban
                                        </a>
                                        <a
                                            class="dropdown-item"
                                            href="/department/create"
                                        >
                                            Tạo phòng ban mới
                                        </a>
                                    </div>
                                </li>
                                @endif
                            </ul>
                            <div
                                class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last"
                            >
                                <form
                                    action="./"
                                    method="get"
                                    autocomplete="off"
                                    novalidate
                                >
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="page-wrapper">
                @yield('main_content')
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
                                        <a href="https://vnpt.com.vn/" class="link-secondary"
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
        <div
            class="modal modal-blur fade"
            id="modal-team"
            tabindex="-1"
            role="dialog"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xem trước biên lai</h5>
                    </div>
                    <div class="modal-body">
                        <div id="receiptPrintBody" style="width: 80mm; height:auto; display:none">
                            <div
                                id="receipt-print-body"
                                style="
                                    border: 1px solid;
                                    font-family: Arial, Helvetica, sans-serif;
                                "
                            >
                                <div id="receipt-header">
                                    <p
                                        style="
                                            margin: 0;
                                            padding: 0;
                                            text-align: center;
                                            font-weight: 600;
                                            margin-top: 10px;
                                            font-size: 17px;
                                        "
                                        id="receipt-name"
                                    >
                                        UBND Phường Cái Khế
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            padding: 0;
                                            text-align: center;
                                            font-size: 12px;
                                        "
                                        id="receipt-taxID"
                                    >
                                        Mã số thuế:
                                    </p>
                                    <p
                                        style="
                                            width: 40mm;
                                            margin: 0 auto;
                                            border-top:1px solid;
                                            padding: 0;
                                            text-align: center;
                                            margin-bottom:10px;
                                        "
                                    >
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            padding: 0;
                                            text-align: center;
                                            margin-top: 5px;
                                            margin-bottom: 5px;
                                            font-size: 15px;
                                            font-weight: 600;
                                            padding: 0 10px;
                                            box-sizing: border-box;
                                        "
                                    >
                                        BIÊN NHẬN
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            padding: 0 10px;
                                            text-align: center;
                                            font-size: 15px;
                                        "
                                    >
                                        Tên phí, lệ phí: <span
                                        id="receipt-fee-name"></span>
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            margin-top:15px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-cus-name"
                                    >
                                        Tên khách hàng:
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-cus-taxID"
                                    >
                                        Mã số thuế:
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-cus-address"
                                    >
                                        Địa chỉ:
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-amount"
                                    >
                                        Số tiền:
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-amount-in-word"
                                    >
                                        (Viết bằng chữ):
                                    </p>
                                    <p
                                        style="
                                            margin: 0;
                                            margin-bottom:5px;
                                            padding: 0 10px;
                                            font-size: 15px;
                                        "
                                        id="receipt-payment-method"
                                    >
                                        Hình thức thanh toán: Tiền mặt
                                    </p>
                                    <div
                                        style="margin-top: 5px;margin-bottom:10px; padding: 0 10px"
                                    >
                                        <div
                                            style="
                                            display: flex;
                                            flex-direction: row;
                                            align-items: center;
                                            margin-top: 20px;
                                            margin-bottom: 20px;
                                            padding: 0 10;
                                            "
                                        >
                                            <p
                                                id="receipt-qrcode"
                                                style="
                                                    margin: 0px;
                                                    width: 80px;
                                                    height: 80px;
                                                "
                                            ></p>
                                        <p
                                                style="
                                                    margin: 0;
                                                    font-size: 13px; 
                                                    margin-left: 10px;
                                                "
                                                id="receipt-pattern-serial"
                                            ></p>
                                            
                                        </div>
                                    </div>
                                    <p id="receipt-footer" style="margin: 0px; margin-bottom:5px; text-align: center; font-size: 10px;  font-weight:600; padding: 0 10px;"></p>
                                    <p style="text-align: center; font-size: 10px;  font-weight:600; padding: 0 10px;">Đơn vị cung cấp giải pháp biên lai điện tử:</br>Tổng Công ty Dịch vụ Viễn thông - VNPT Vinaphone</p>
                                </div>
                            </div>
                        </div>
                        <div class="load-container" id="loadContainerViewReceipt">
                            <div class="blocks b-one"></div>
                            <div class="blocks b-two"></div>
                            <div class="blocks b-three"></div>
                            <div class="blocks b-four"></div>
                            <div class="blocks b-five"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn me-auto"
                            data-bs-dismiss="modal"
                            id = "closeReceiptPrintBody"
                        >
                            Đóng
                        </button>
                        <a
                            href=""
                            type="button"
                            class="btn btn-info"
                            id="btnReplaceReceipt"
                            >Thay Thế</a
                        >
                        <a
                            href=""
                            type="button"
                            class="btn btn-success"
                            id="btnAdjustReceipt"target="_blank"
                            >Điều Chỉnh</a
                        >
                        <p
                            type="button"
                            class="btn btn-primary"
                            id="printReceiptBtn"target="_blank"
                        >
                            In
                        </p>
                        <script>
                            document
                                .getElementById("printReceiptBtn")
                                .addEventListener("click", function () {
                                    var receiptPrintBody =
                                        document.getElementById(
                                            "receiptPrintBody"
                                        );
                                    var printWindow = window.open(
                                        "",
                                        "",
                                        "width=800,height=800"
                                    );
                                    printWindow.document.write(
                                        receiptPrintBody.innerHTML
                                    );
                                    printWindow.document.open();
                                    printWindow.document.write(
                                        "<html><head><title>In ấn</title></head><body style='margin:2px;'>"
                                    );
                                    printWindow.document.write(
                                        '<div style="width: 80mm; height: auto;">' +
                                            receiptPrintBody.innerHTML +
                                            "</div>"
                                    );
                                    printWindow.document.write(
                                        "</body></html>"
                                    );
                                    printWindow.document.close();
                                    printWindow.print();
                                    printWindow.close();
                                });
                            
                            document
                                .getElementById("closeReceiptPrintBody")
                                .addEventListener("click", function () {
                                    // Bỏ giao diện và show loading
                                    document.getElementById("receiptPrintBody").style.display="none";
                                    document.getElementById("loadContainerViewReceipt").style.display="flex";
                                });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!-- Libs JS -->
        <script src="{{asset('libs/apexcharts/dist/apexcharts.min.js')}}" defer></script>
        <script src="{{asset('libs/jsvectormap/dist/js/jsvectormap.min.js')}}" defer></script>
        <script src="{{asset('libs/jsvectormap/dist/maps/world.js')}}" defer></script>
        <script src="{{asset('libs/jsvectormap/dist/maps/world-merc.js')}}" defer></script>
        <script src="{{asset('js/tabler.min.js')}}" defer></script>
        <script src="{{asset('js/demo.min.js')}}" defer></script>
        <script src="{{asset('js/extends.js')}}"></script>
    </body>
</html>
