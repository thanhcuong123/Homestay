@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách chủ Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa người dùng</h2>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <textarea name="address" class="form-control">{{ $user->address }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-control">
                <option value="">-- Chọn giới tính --</option>
                <option value="Nam" {{ $user->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ $user->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ $user->date_of_birth }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh đại diện hiện tại</label><br>
            <img src="{{ asset('storage/' . $user->avatar) }}" class="square-image" width="100" height="100" alt="Avatar">
        </div>

        <div class="mb-3">
            <label class="form-label">Cập nhật ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

@endsection
