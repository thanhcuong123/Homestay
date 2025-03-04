@extends('admin.admin_layout')
@section('title-content')
<title>Thêm loại phòng</title>
@endsection
@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm loại phòng</h2>

    <form action="{{route('roomtype.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Chọn Homestay</label>
            <select name="homestay_id" class="form-control">
                <option value="">-- Chọn Homestay --</option>
                @foreach ($homestay as $homestay)
                <option value="{{ $homestay->id }}">{{ $homestay->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên loại</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số người ở tối đa</label>
            <input type="text" name="max_guests" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Diện tích phòng</label>
            <input type="text" name="area" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá phòng</label>
            <input type="text" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Các tiện nghi đi kèm</label>
            <textarea name="amenities" class="form-control" rows="4" required></textarea>
        </div>


        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>






@endsection