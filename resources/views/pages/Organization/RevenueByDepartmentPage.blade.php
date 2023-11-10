@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Doanh thu của phòng ban</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            @if(session('message'))
            <div
                class="alert alert-{{ session('type') == 'ERR' ? 'danger' : 'success' }}"
                role="alert"
            >
                <h4 class="alert-title">
                    {{ session('type') == 'ERR' ? 'Cảnh báo' : 'Thông báo' }}
                </h4>
                <div class="text-secondary">{{ session('message') }}</div>
            </div>
            @endif
            <div class="row m-0">
                <form action="/department/revenue" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Chọn phòng ban</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-1 col-xl-1">
                                <div class="mb-1">
                                    <label class="form-label">Phòng ban</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-3">
                                <div class="mb-2">
                                    <select
                                        class="form-select"
                                        name="idDepartment"
                                    >
                                        @foreach($dataDepartment as $key =>
                                        $department)
                                        <option value="{{$department['id']}}" <?php  if($dataSearch['idDepartment']){if($department['id'] == $dataSearch['idDepartment']){ echo "selected"; }} ?>>
                                            {{$department["name"]}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 col-xl-1">
                                <div class="mb-1">
                                    <label class="form-label">Từ ngày</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-2">
                                    <input
                                        type="date"
                                        class="form-control"
                                        name="dateFrom"
                                        value="<?php echo $dataSearch['dateFrom'] ?? null; ?>"
                                    />
                                </div>
                            </div>
                            <div class="col-md-1 col-xl-1">
                                <div class="mb-1">
                                    <label class="form-label">Đến ngày</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-2">
                                    <input
                                        type="date"
                                        class="form-control"
                                        name="dateTo"
                                        value="<?php echo $dataSearch['dateTo'] ?? null; ?>"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="mb-2">
                                    <button class="btn">Xác nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tỷ lệ các loại biên lai</h3>
                    </div>
                    <canvas
                        id="chart-type-receipt"
                        width="400"
                        height="400"
                    ></canvas>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Danh sách biên lai của UBND Phường Cái Khế
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table
                            class="table card-table table-vcenter text-nowrap datatable"
                        >
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên người dùng</th>
                                    <th>Mã số thuế</th>
                                    <th>Loại biên lai</th>
                                    <th>Phương thức</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $totalRevenue = 0;?>
                            @foreach($dataListReceipt as $key => $receipt)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$receipt["customer_name"]}}</td>
                                <td>{{$receipt["fee_name"]}}</td>
                                <td>{{($receipt["type"] == 1) ? "Biên lai gốc" : (($receipt["type"] >= 2 && $receipt["type"] <= 4) ? "Biên lai điều chỉnh" : ($receipt["type"] == 5 ? "Biên lai thay thế" : "Không rõ"));}}</td>
                                <td>{{$receipt["payment_method"] == "TM" ? "Tiền mặt" : "Chưa rõ" }}</td>
                                <td>{{number_format($receipt["amount"])}}đ</td>
                            </tr>
                            <?php $totalRevenue += $receipt["amount"];?>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>Tổng doanh thu</th>
                                <th>{{number_format($totalRevenue)}}đ</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById("chart-type-receipt").getContext("2d");
    const type1Count = <?php echo isset($dataTypeReceipt['Type1']) ? $dataTypeReceipt['Type1'] : 0; ?>;
    const type234Count = <?php echo isset($dataTypeReceipt['Type234']) ? $dataTypeReceipt['Type234'] : 0; ?>;
    const type5Count = <?php echo isset($dataTypeReceipt['Type5']) ? $dataTypeReceipt['Type5'] : 0; ?>;
    const myChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Biên Lai Gốc", "Biên Lai Điều Chỉnh", "Biên Lai Thay Thế"],
            datasets: [
                {
                    data: [type1Count, type234Count, type5Count],
                    backgroundColor: [
                        "rgba(47, 179, 68, 0.7)",
                        "rgba(66, 153, 225, 0.7)",
                        "rgba(247, 103, 7, 0.7)"
                    ],
                },
            ],
        },
    });
</script>
@endsection
