@extends('admin.admin_layout')
@section('title-content')
<title>Thêm phòng</title>
@endsection
@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm phòng</h2>

    <form action="{{route('room.store')}}" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="mb-3">
            <label class="form-label">Chọn loại phòng</label>
            <select name="room_type_id" class="form-control">
                <option value="">-- Chọn loại phòng --</option>
                @foreach ($roomtype as $roomtype)
                <option value="{{ $roomtype->id }}">{{ $roomtype->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Số phòng</label>
            <input type="text" name="room_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái phòng</label>
            <select name="status" class="form-control" required>
                <option value="đã có người ở">Đã có người ở</option>
                <option value="đã đặt">Đã đặt</option>
                <option value="còn trống">Còn trống</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình ảnh phòng</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>

        </div>



        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection