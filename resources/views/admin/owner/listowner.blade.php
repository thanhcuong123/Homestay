@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách chủ Homestay</title>
@endsection

@section('main-content')
<div class="table-responsive mt-4">
    <h2 class="text-2xl font-bold mb-4">Danh sách chủ Homestay</h2>
    <a href="{{ route('admin.owner.create') }}" class="btn btn-success" style="margin-left:4px">Thêm mới</a>
    <table class="table table-bordered table-striped table-fixed">
        <thead class="">
            <tr>
                <th>Stt</th>
                <th>Tên</th>
                <th>Giới tính</th>
                <th> Số điện thoại</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th class="sticky-column">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($owners as $key => $owner)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $owner->name }}</td>
                <td>{{ $owner->gender }}</td>
                <td>{{ $owner->phone}}</td>
                <td>{{ $owner->created_at }}</td>
                <td>{{ $owner->updated_at }}</td>
                <td class="sticky-column">
                    <a href="{{ route('owner.edit',['id' => $owner ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('owner.destroy',$owner -> id) }}" method="POST" style="display:inline;">
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
@endsection