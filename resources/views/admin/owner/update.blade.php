@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách chủ Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa chủ sở hữu</h2>

    <form action="{{ route('admin.owner.update', $owner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" value="{{ $owner->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-control" required>
                <option value="">-- Chọn giới tính --</option>
                <option value="Nam" {{ $owner->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ $owner->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $owner->phone }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh đại diện hiện tại</label><br>
            <img src="{{ asset('storage/' . $owner->avatar) }}" class="square-image" width="100" height="100" alt="Avatar">
        </div>

        <div class="mb-3">
            <label class="form-label">Cập nhật ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

@endsection
