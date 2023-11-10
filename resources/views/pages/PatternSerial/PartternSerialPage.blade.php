@extends('main')
@section('main_content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Mẫu số/Ký hiệu</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @if(session('message'))
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-title">Thông báo</h4>
                    <div class="text-secondary">{{ session('message') }}</div>
                </div>
            @endif
            <div class="col-6">
                <form class="row mb-3" action="/pattern/create" method="POST">
                    @csrf
                    <div class="col-2"><label class="form-label">Thêm mẫu số</label></div>
                    <div class="col-6"><input type="text" class="form-control" placeholder="" name="pattern" required=""></div>
                    <div class="col-1">
                        <button type="submit" class="btn">
                            Thêm
                        </button>
                    </div>
                </form>
                <div class="table-responsive card">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mẫu số</th>
                                <th>Ngày tạo</th>
                            </tr>
                            @foreach($dataPattern as $key => $pattern)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$pattern["pattern"]}}</td>
                                <td>{{ \Carbon\Carbon::parse($pattern["created_at"])->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <form class="row mb-3" action="/serial/create" method="POST">
                    @csrf
                    <div class="col-2"><label class="form-label">Thêm ký hiệu</label></div>
                    <div class="col-3"><input type="text" class="form-control" placeholder="" name="serial" required=""></div>
                    <div class="col-3"><label class="form-label">Thuộc mẫu số</label></div>
                    <div class="col-3">
                        <select class="form-select" name="pattern_id" id="feeSelect">
                             @foreach($dataPattern as $key => $pattern)
                            <option value="{{$pattern['id']}}">{{$pattern['pattern']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn">
                            Thêm
                        </button>
                    </div>
                </form>
                <div class="table-responsive card">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ký hiệu</th>
                                <th>Thuộc mẫu số</th>
                                <th>Ngày tạo</th>
                                </th>
                            </tr>
                            @foreach($dataSerial as $key => $serial)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$serial["serial"]}}</td>
                                <td>{{$serial["pattern"]}}</td>
                                <td>{{ \Carbon\Carbon::parse($serial["created_at"])->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-6"></div>
            <div class="col-6"></div>
        </div>
    </div>
</div>
@endsection
