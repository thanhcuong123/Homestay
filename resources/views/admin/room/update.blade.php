@extends('admin.admin_layout')
@section('title-content')
<title>Chỉnh sửa phòng</title>
@endsection
@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa phòng</h2>

    <form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên loại phòng</label>
            <select name="room_type_id" class="form-control" required>
                <option value="">-- Chọn loại phòng --</option>
                @foreach ($roomtypes as $roomtype)
                <option value="{{ $roomtype->id }}" {{ $room->room_type_id == $roomtype->id ? 'selected' : '' }}>
                    {{ $roomtype->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Số phòng</label>
            <input type="text" name="room_number" class="form-control" value="{{ $room->room_number }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="đã có người ở" {{ $room->status == 'đã có người ở' ? 'selected' : '' }}>Đã có người ở</option>
                <option value="đã đặt" {{ $room->status == 'đã đặt' ? 'selected' : '' }}>Đã đặt</option>
                <option value="còn trống" {{ $room->status == 'còn trống' ? 'selected' : '' }}>Còn trống</option>
            </select>
        </div>



        <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label><br>
            <img src="{{ asset('storage/'.$room->image) }}" class="square-image" width="100" height="100" alt="Room Image">
        </div>

        <div class="mb-3">
            <label class="form-label">Cập nhật hình ảnh mới</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection