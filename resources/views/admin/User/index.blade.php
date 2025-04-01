@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách chủ Homestay</title>
@endsection

@section('main-content')
<div class="table-responsive mt-4">
    <h2 class="text-2xl font-bold mb-4">Danh sách chủ User</h2>
    <a href="{{ route('admin.user.create') }}" class="btn btn-success" style="margin-left:4px">Thêm mới</a>
    <table class="table table-bordered table-striped table-fixed">
        <thead class="">
            <tr>
                <th>Stt</th>
                <th>Tên</th>
                <th>Mật khẩu</th>
                <th>Email</th>
                <th> Số điện thoại</th>
                <th>Quyền</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Avatar</th>

                <th class="sticky-column">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->phone}}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->date_of_birth }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->avatar }}</td>

                <td class="sticky-column">
                    <a href="{{ route('admin.user.edit',['id' => $user ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.user.destroy',$user -> id) }}" method="POST" style="display:inline;">
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
