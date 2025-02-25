@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách Homestay</title>
@endsection


@section('main-content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<style>
    /* .table-fixed {
        table-layout: fixed;
        width: 100%;
    } */

    .fixed-column {
        width: 500px;
        word-wrap: break-word;
        white-space: normal;
    }

    .sticky-column {
        position: sticky;
        right: 0;
        background-color: white;

        z-index: 2;
        min-width: 120px;

    }
</style>
<div class="table-responsive">
    <div class="containers mt-4">
        <div class="d-flex justify-content align-items-center mb-3">
            <h3 class="mb-1">Danh sách Homestay</h3>
            <a href="{{ route('admin.homestay.create') }}" class="btn btn-success" style="margin-left:4px">Thêm mới</a>

        </div>
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
                    <th>Chủ</th>
                    <th>Tên Homestay</th>
                    <th class="fixed-column">Địa chỉ</th>
                    <th>Vĩ độ</th>
                    <th>Kinh độ</th>
                    <th>Đơn vị hành chính</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th class="sticky-column">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($homestay as $key => $homestay)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $homestay->owner->name ?? 'khong' }}</td>
                    <td>{{ $homestay->name }}</td>
                    <td class="fixed-column">
                        <div class="text-wrap">{{ $homestay->address }}</div>
                    </td>
                    <td>{{ $homestay->latitude }}</td>
                    <td>{{ $homestay->longitude }}</td>
                    <td>{{ $homestay->administrativeUnit ->name ?? 'khong' }}</td>
                    <td>{{ $homestay->created_at }}</td>
                    <td>{{ $homestay->updated_at }}</td>
                    <td class="sticky-column">
                        <a href="{{ route('admin.homestay.edit',['id' => $homestay ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.homestay.destroy',$homestay -> id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection