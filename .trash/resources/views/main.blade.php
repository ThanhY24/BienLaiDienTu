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
                                    style="
                                        background-image: url('https://cdn-icons-png.flaticon.com/512/9131/9131529.png');
                                    "
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
                                        id="receipt-fee-name"style='border-bottom: 1px dotted rgb(67, 57, 101); display: inline-block; min-width: 40mm; text-align: left;'></span>
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
                            id="btnAdjustReceipt"
                            >Điều Chỉnh</a
                        >
                        <p
                            type="button"
                            class="btn btn-primary"
                            id="printReceiptBtn"
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
        <script src="{{asset('libs/apexcharts/dist/apexcharts.min.js')}}" defer>
            </scrip>
                <script
                  src="{{asset('libs/jsvectormap/dist/js/jsvectormap.min.js')}}"
                  defer
                >
        </script>
        <script
            src="{{asset('libs/jsvectormap/dist/maps/world.js')}}"
            defer
        ></script>
        <script
            src="{{asset('libs/jsvectormap/dist/maps/world-merc.js')}}"
            defer
        ></script>
        <!-- Tabler Core -->
        <script src="{{asset('js/tabler.min.js')}}" defer></script>
        <script src="{{asset('js/demo.min.js')}}" defer></script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("chart-revenue-bg"),
                        {
                            chart: {
                                type: "area",
                                fontFamily: "inherit",
                                height: 40.0,
                                sparkline: {
                                    enabled: true,
                                },
                                animations: {
                                    enabled: false,
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            fill: {
                                opacity: 0.16,
                                type: "solid",
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                                curve: "smooth",
                            },
                            series: [
                                {
                                    name: "Profits",
                                    data: [
                                        37, 35, 44, 28, 36, 24, 65, 31, 37, 39,
                                        62, 51, 35, 41, 35, 27, 93, 53, 61, 27,
                                        54, 43, 19, 46, 39, 62, 51, 35, 41, 67,
                                    ],
                                },
                            ],
                            tooltip: {
                                theme: "dark",
                            },
                            grid: {
                                strokeDashArray: 4,
                            },
                            xaxis: {
                                labels: {
                                    padding: 0,
                                },
                                tooltip: {
                                    enabled: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                type: "datetime",
                            },
                            yaxis: {
                                labels: {
                                    padding: 4,
                                },
                            },
                            labels: [
                                "2020-06-20",
                                "2020-06-21",
                                "2020-06-22",
                                "2020-06-23",
                                "2020-06-24",
                                "2020-06-25",
                                "2020-06-26",
                                "2020-06-27",
                                "2020-06-28",
                                "2020-06-29",
                                "2020-06-30",
                                "2020-07-01",
                                "2020-07-02",
                                "2020-07-03",
                                "2020-07-04",
                                "2020-07-05",
                                "2020-07-06",
                                "2020-07-07",
                                "2020-07-08",
                                "2020-07-09",
                                "2020-07-10",
                                "2020-07-11",
                                "2020-07-12",
                                "2020-07-13",
                                "2020-07-14",
                                "2020-07-15",
                                "2020-07-16",
                                "2020-07-17",
                                "2020-07-18",
                                "2020-07-19",
                            ],
                            colors: [tabler.getColor("primary")],
                            legend: {
                                show: false,
                            },
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("chart-new-clients"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 40.0,
                                sparkline: {
                                    enabled: true,
                                },
                                animations: {
                                    enabled: false,
                                },
                            },
                            fill: {
                                opacity: 1,
                            },
                            stroke: {
                                width: [2, 1],
                                dashArray: [0, 3],
                                lineCap: "round",
                                curve: "smooth",
                            },
                            series: [
                                {
                                    name: "May",
                                    data: [
                                        37, 35, 44, 28, 36, 24, 65, 31, 37, 39,
                                        62, 51, 35, 41, 35, 27, 93, 53, 61, 27,
                                        54, 43, 4, 46, 39, 62, 51, 35, 41, 67,
                                    ],
                                },
                                {
                                    name: "April",
                                    data: [
                                        93, 54, 51, 24, 35, 35, 31, 67, 19, 43,
                                        28, 36, 62, 61, 27, 39, 35, 41, 27, 35,
                                        51, 46, 62, 37, 44, 53, 41, 65, 39, 37,
                                    ],
                                },
                            ],
                            tooltip: {
                                theme: "dark",
                            },
                            grid: {
                                strokeDashArray: 4,
                            },
                            xaxis: {
                                labels: {
                                    padding: 0,
                                },
                                tooltip: {
                                    enabled: false,
                                },
                                type: "datetime",
                            },
                            yaxis: {
                                labels: {
                                    padding: 4,
                                },
                            },
                            labels: [
                                "2020-06-20",
                                "2020-06-21",
                                "2020-06-22",
                                "2020-06-23",
                                "2020-06-24",
                                "2020-06-25",
                                "2020-06-26",
                                "2020-06-27",
                                "2020-06-28",
                                "2020-06-29",
                                "2020-06-30",
                                "2020-07-01",
                                "2020-07-02",
                                "2020-07-03",
                                "2020-07-04",
                                "2020-07-05",
                                "2020-07-06",
                                "2020-07-07",
                                "2020-07-08",
                                "2020-07-09",
                                "2020-07-10",
                                "2020-07-11",
                                "2020-07-12",
                                "2020-07-13",
                                "2020-07-14",
                                "2020-07-15",
                                "2020-07-16",
                                "2020-07-17",
                                "2020-07-18",
                                "2020-07-19",
                            ],
                            colors: [
                                tabler.getColor("primary"),
                                tabler.getColor("gray-600"),
                            ],
                            legend: {
                                show: false,
                            },
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("chart-active-users"),
                        {
                            chart: {
                                type: "bar",
                                fontFamily: "inherit",
                                height: 40.0,
                                sparkline: {
                                    enabled: true,
                                },
                                animations: {
                                    enabled: false,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: "50%",
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            fill: {
                                opacity: 1,
                            },
                            series: [
                                {
                                    name: "Profits",
                                    data: [
                                        37, 35, 44, 28, 36, 24, 65, 31, 37, 39,
                                        62, 51, 35, 41, 35, 27, 93, 53, 61, 27,
                                        54, 43, 19, 46, 39, 62, 51, 35, 41, 67,
                                    ],
                                },
                            ],
                            tooltip: {
                                theme: "dark",
                            },
                            grid: {
                                strokeDashArray: 4,
                            },
                            xaxis: {
                                labels: {
                                    padding: 0,
                                },
                                tooltip: {
                                    enabled: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                type: "datetime",
                            },
                            yaxis: {
                                labels: {
                                    padding: 4,
                                },
                            },
                            labels: [
                                "2020-06-20",
                                "2020-06-21",
                                "2020-06-22",
                                "2020-06-23",
                                "2020-06-24",
                                "2020-06-25",
                                "2020-06-26",
                                "2020-06-27",
                                "2020-06-28",
                                "2020-06-29",
                                "2020-06-30",
                                "2020-07-01",
                                "2020-07-02",
                                "2020-07-03",
                                "2020-07-04",
                                "2020-07-05",
                                "2020-07-06",
                                "2020-07-07",
                                "2020-07-08",
                                "2020-07-09",
                                "2020-07-10",
                                "2020-07-11",
                                "2020-07-12",
                                "2020-07-13",
                                "2020-07-14",
                                "2020-07-15",
                                "2020-07-16",
                                "2020-07-17",
                                "2020-07-18",
                                "2020-07-19",
                            ],
                            colors: [tabler.getColor("primary")],
                            legend: {
                                show: false,
                            },
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(document.getElementById("chart-mentions"), {
                        chart: {
                            type: "bar",
                            fontFamily: "inherit",
                            height: 240,
                            parentHeightOffset: 0,
                            toolbar: {
                                show: false,
                            },
                            animations: {
                                enabled: false,
                            },
                            stacked: true,
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "50%",
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        fill: {
                            opacity: 1,
                        },
                        series: [
                            {
                                name: "Web",
                                data: [
                                    1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8,
                                    22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47,
                                    23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6,
                                ],
                            },
                            {
                                name: "Social",
                                data: [
                                    2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6,
                                    7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13,
                                    15, 20, 47, 18, 15, 11, 10, 0,
                                ],
                            },
                            {
                                name: "Other",
                                data: [
                                    2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3,
                                    6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3,
                                    2, 3, 4, 9, 7, 1, 6,
                                ],
                            },
                        ],
                        tooltip: {
                            theme: "dark",
                        },
                        grid: {
                            padding: {
                                top: -20,
                                right: 0,
                                left: -4,
                                bottom: -4,
                            },
                            strokeDashArray: 4,
                            xaxis: {
                                lines: {
                                    show: true,
                                },
                            },
                        },
                        xaxis: {
                            labels: {
                                padding: 0,
                            },
                            tooltip: {
                                enabled: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            type: "datetime",
                        },
                        yaxis: {
                            labels: {
                                padding: 4,
                            },
                        },
                        labels: [
                            "2020-06-20",
                            "2020-06-21",
                            "2020-06-22",
                            "2020-06-23",
                            "2020-06-24",
                            "2020-06-25",
                            "2020-06-26",
                            "2020-06-27",
                            "2020-06-28",
                            "2020-06-29",
                            "2020-06-30",
                            "2020-07-01",
                            "2020-07-02",
                            "2020-07-03",
                            "2020-07-04",
                            "2020-07-05",
                            "2020-07-06",
                            "2020-07-07",
                            "2020-07-08",
                            "2020-07-09",
                            "2020-07-10",
                            "2020-07-11",
                            "2020-07-12",
                            "2020-07-13",
                            "2020-07-14",
                            "2020-07-15",
                            "2020-07-16",
                            "2020-07-17",
                            "2020-07-18",
                            "2020-07-19",
                            "2020-07-20",
                            "2020-07-21",
                            "2020-07-22",
                            "2020-07-23",
                            "2020-07-24",
                            "2020-07-25",
                            "2020-07-26",
                        ],
                        colors: [
                            tabler.getColor("primary"),
                            tabler.getColor("primary", 0.8),
                            tabler.getColor("green", 0.8),
                        ],
                        legend: {
                            show: false,
                        },
                    }).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:on
            document.addEventListener("DOMContentLoaded", function () {
                const map = new jsVectorMap({
                    selector: "#map-world",
                    map: "world",
                    backgroundColor: "transparent",
                    regionStyle: {
                        initial: {
                            fill: tabler.getColor("body-bg"),
                            stroke: tabler.getColor("border-color"),
                            strokeWidth: 2,
                        },
                    },
                    zoomOnScroll: false,
                    zoomButtons: false,
                    // -------- Series --------
                    visualizeData: {
                        scale: [
                            tabler.getColor("bg-surface"),
                            tabler.getColor("primary"),
                        ],
                        values: {
                            AF: 16,
                            AL: 11,
                            DZ: 158,
                            AO: 85,
                            AG: 1,
                            AR: 351,
                            AM: 8,
                            AU: 1219,
                            AT: 366,
                            AZ: 52,
                            BS: 7,
                            BH: 21,
                            BD: 105,
                            BB: 3,
                            BY: 52,
                            BE: 461,
                            BZ: 1,
                            BJ: 6,
                            BT: 1,
                            BO: 19,
                            BA: 16,
                            BW: 12,
                            BR: 2023,
                            BN: 11,
                            BG: 44,
                            BF: 8,
                            BI: 1,
                            KH: 11,
                            CM: 21,
                            CA: 1563,
                            CV: 1,
                            CF: 2,
                            TD: 7,
                            CL: 199,
                            CN: 5745,
                            CO: 283,
                            KM: 0,
                            CD: 12,
                            CG: 11,
                            CR: 35,
                            CI: 22,
                            HR: 59,
                            CY: 22,
                            CZ: 195,
                            DK: 304,
                            DJ: 1,
                            DM: 0,
                            DO: 50,
                            EC: 61,
                            EG: 216,
                            SV: 21,
                            GQ: 14,
                            ER: 2,
                            EE: 19,
                            ET: 30,
                            FJ: 3,
                            FI: 231,
                            FR: 2555,
                            GA: 12,
                            GM: 1,
                            GE: 11,
                            DE: 3305,
                            GH: 18,
                            GR: 305,
                            GD: 0,
                            GT: 40,
                            GN: 4,
                            GW: 0,
                            GY: 2,
                            HT: 6,
                            HN: 15,
                            HK: 226,
                            HU: 132,
                            IS: 12,
                            IN: 1430,
                            ID: 695,
                            IR: 337,
                            IQ: 84,
                            IE: 204,
                            IL: 201,
                            IT: 2036,
                            JM: 13,
                            JP: 5390,
                            JO: 27,
                            KZ: 129,
                            KE: 32,
                            KI: 0,
                            KR: 986,
                            KW: 117,
                            KG: 4,
                            LA: 6,
                            LV: 23,
                            LB: 39,
                            LS: 1,
                            LR: 0,
                            LY: 77,
                            LT: 35,
                            LU: 52,
                            MK: 9,
                            MG: 8,
                            MW: 5,
                            MY: 218,
                            MV: 1,
                            ML: 9,
                            MT: 7,
                            MR: 3,
                            MU: 9,
                            MX: 1004,
                            MD: 5,
                            MN: 5,
                            ME: 3,
                            MA: 91,
                            MZ: 10,
                            MM: 35,
                            NA: 11,
                            NP: 15,
                            NL: 770,
                            NZ: 138,
                            NI: 6,
                            NE: 5,
                            NG: 206,
                            NO: 413,
                            OM: 53,
                            PK: 174,
                            PA: 27,
                            PG: 8,
                            PY: 17,
                            PE: 153,
                            PH: 189,
                            PL: 438,
                            PT: 223,
                            QA: 126,
                            RO: 158,
                            RU: 1476,
                            RW: 5,
                            WS: 0,
                            ST: 0,
                            SA: 434,
                            SN: 12,
                            RS: 38,
                            SC: 0,
                            SL: 1,
                            SG: 217,
                            SK: 86,
                            SI: 46,
                            SB: 0,
                            ZA: 354,
                            ES: 1374,
                            LK: 48,
                            KN: 0,
                            LC: 1,
                            VC: 0,
                            SD: 65,
                            SR: 3,
                            SZ: 3,
                            SE: 444,
                            CH: 522,
                            SY: 59,
                            TW: 426,
                            TJ: 5,
                            TZ: 22,
                            TH: 312,
                            TL: 0,
                            TG: 3,
                            TO: 0,
                            TT: 21,
                            TN: 43,
                            TR: 729,
                            TM: 0,
                            UG: 17,
                            UA: 136,
                            AE: 239,
                            GB: 2258,
                            US: 4624,
                            UY: 40,
                            UZ: 37,
                            VU: 0,
                            VE: 285,
                            VN: 101,
                            YE: 30,
                            ZM: 15,
                            ZW: 5,
                        },
                    },
                });
                window.addEventListener("resize", () => {
                    map.updateSize();
                });
            });
            // @formatter:off
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-activity"),
                        {
                            chart: {
                                type: "radialBar",
                                fontFamily: "inherit",
                                height: 40,
                                width: 40,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            plotOptions: {
                                radialBar: {
                                    hollow: {
                                        margin: 0,
                                        size: "75%",
                                    },
                                    track: {
                                        margin: 0,
                                    },
                                    dataLabels: {
                                        show: false,
                                    },
                                },
                            },
                            colors: [tabler.getColor("blue")],
                            series: [35],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("chart-development-activity"),
                        {
                            chart: {
                                type: "area",
                                fontFamily: "inherit",
                                height: 192,
                                sparkline: {
                                    enabled: true,
                                },
                                animations: {
                                    enabled: false,
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            fill: {
                                opacity: 0.16,
                                type: "solid",
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                                curve: "smooth",
                            },
                            series: [
                                {
                                    name: "Purchases",
                                    data: [
                                        3, 5, 4, 6, 7, 5, 6, 8, 24, 7, 12, 5, 6,
                                        3, 8, 4, 14, 30, 17, 19, 15, 14, 25, 32,
                                        40, 55, 60, 48, 52, 70,
                                    ],
                                },
                            ],
                            tooltip: {
                                theme: "dark",
                            },
                            grid: {
                                strokeDashArray: 4,
                            },
                            xaxis: {
                                labels: {
                                    padding: 0,
                                },
                                tooltip: {
                                    enabled: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                type: "datetime",
                            },
                            yaxis: {
                                labels: {
                                    padding: 4,
                                },
                            },
                            labels: [
                                "2020-06-20",
                                "2020-06-21",
                                "2020-06-22",
                                "2020-06-23",
                                "2020-06-24",
                                "2020-06-25",
                                "2020-06-26",
                                "2020-06-27",
                                "2020-06-28",
                                "2020-06-29",
                                "2020-06-30",
                                "2020-07-01",
                                "2020-07-02",
                                "2020-07-03",
                                "2020-07-04",
                                "2020-07-05",
                                "2020-07-06",
                                "2020-07-07",
                                "2020-07-08",
                                "2020-07-09",
                                "2020-07-10",
                                "2020-07-11",
                                "2020-07-12",
                                "2020-07-13",
                                "2020-07-14",
                                "2020-07-15",
                                "2020-07-16",
                                "2020-07-17",
                                "2020-07-18",
                                "2020-07-19",
                            ],
                            colors: [tabler.getColor("primary")],
                            legend: {
                                show: false,
                            },
                            point: {
                                show: false,
                            },
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-1"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [17, 24, 20, 10, 5, 1, 4, 18, 13],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-2"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [13, 11, 19, 22, 12, 7, 14, 3, 21],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-3"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [10, 13, 10, 4, 17, 3, 23, 22, 19],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-4"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [6, 15, 13, 13, 5, 7, 17, 20, 19],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-5"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [
                                        2, 11, 15, 14, 21, 20, 8, 23, 18, 14,
                                    ],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function () {
                window.ApexCharts &&
                    new ApexCharts(
                        document.getElementById("sparkline-bounce-rate-6"),
                        {
                            chart: {
                                type: "line",
                                fontFamily: "inherit",
                                height: 24,
                                animations: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                lineCap: "round",
                            },
                            series: [
                                {
                                    color: tabler.getColor("primary"),
                                    data: [22, 12, 7, 14, 3, 21, 8, 23, 18, 14],
                                },
                            ],
                        }
                    ).render();
            });
            // @formatter:on
        </script>
        <script src="{{asset('js/extends.js')}}"></script>
    </body>
</html>
