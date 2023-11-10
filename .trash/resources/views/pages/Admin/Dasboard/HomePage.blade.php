@extends('main') @section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Tổng quan</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            @if(session('message'))
                <div class="alert alert-{{ session('type') == 'ERR' ? 'danger' : 'success' }}" role="alert">
                    <h4 class="alert-title">{{ session('type') == 'ERR' ? 'Cảnh báo' : 'Thông báo' }}</h4>
                    <div class="text-secondary">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tỷ Lệ Các Loại Biên Lai Trong Ngày</h3>
                    </div>
                    <canvas id="chart-type-receipt" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh Sách Biên Lai Trong Ngày Và Doanh Thu Trong Ngày</h3>
                    </div>
                    <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Tên người dùng</th>
                          <th>Mã số thuế</th>
                          <th>Tổng biên lai</th>
                          <th>Tổng doanh thu</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($listRevenue as $key => $itemRevenue)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$itemRevenue[0]}}</td>
                            <td>{{$itemRevenue[1]}}</td>
                            <td>{{$itemRevenue[2]}}</td>
                            <td>{{number_format($itemRevenue[3])}} đ</td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById("chart-type-receipt").getContext("2d");
    const type1Count = <?php echo $dataTypeReceipt['Type1']; ?>;
    const type234Count = <?php echo $dataTypeReceipt['Type234'] ?>;
    const type5Count = <?php echo $dataTypeReceipt['Type5']; ?>;

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
