@extends('admin.admin_layout')
@section('title-content')
<title>Quản lí điểm du lịch</title>
@endsection

@section('main-content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<div class="table-responsive">
    <div class="containers mt-4">
        <div class="d-flex justify-content align-items-center mb-3">
            <h3 class="mb-1">Danh sách Homestay</h3>
            <a href="{{ route('tourist.create') }}" class="btn btn-success" style="margin-left:4px; margin-right:10px">Thêm mới</a>
            <a href="{{ route('tourist.mapall') }}" class="btn btn-primary">Xem các điểm du lịch trên bản đồ</a>

        </div>
        <h6>Nhấn đúp chuột để chọn xem vị trí trên map của các điểm du lịch</h6>
        @if(session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
            }).showToast();
        </script>
        @endif
        <table class="table table-bordered table-striped table-fixed">
            <thead class="">
                <tr>
                    <th>Stt</th>
                    <th>Tên</th>
                    <th class="fixed-column">Địa chỉ</th>
                    <th>Vĩ độ</th>
                    <th>Kinh độ</th>
                    <th>Hình ảnh</th>
                    <th class="sticky-column">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tourist as $key => $tourist)

                <tr data-lat="{{ $tourist->latitude }}" data-lng="{{ $tourist->longitude }}" ondblclick="redirectToMap(this)" style="cursor: pointer;">

                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tourist->name }}</td>
                    <td class="fixed-column">
                        <div class="text-wrap">{{ $tourist->address }}</div>
                    </td>
                    <td>{{ $tourist->latitude }}</td>
                    <td>{{ $tourist->longitude }}</td>
                    <td>@if($tourist->icon)
                        <img src="{{ asset('storage/' . $tourist->icon) }}" alt="{{ $tourist->name }}" width="1100" height="70" style="border-radius: 8px;">
                        @else
                        <span>Chưa cập nhật</span>
                        @endif
                    </td>
                    <td class="sticky-column">
                        <a href="{{ route('tourist.edit',['id' => $tourist ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('tourist.destroy',$tourist -> id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            function redirectToMap(row) {
                var lat = row.getAttribute("data-lat") || 0;
                var lng = row.getAttribute("data-lng") || 0;
                window.location.href = "/admin/tourist/map?lat=" + lat + "&lng=" + lng;
            }
        </script>


    </div>
</div>
@endsection