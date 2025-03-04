@extends('admin.admin_layout')
@section('title-content')
<title>Sửa loại phòng</title>
@endsection
@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa loại phòng</h2>

    <form action="{{ route('roomtype.update', $roomtype->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên Homestay</label>
            <select name="homestay_id" class="form-control" required>
                <option value="">-- Chọn homestay --</option>
                @foreach ($homestay as $homestay)
                <option value="{{ $homestay->id }}" {{ $roomtype->homestay_id == $homestay->id ? 'selected' : '' }}>{{ $homestay->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên loại phòng</label>
            <input type="text" name="name" class="form-control" value="{{ $roomtype->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"> Số người ở tối đa</label>
            <input type="text" name="max_guests" class="form-control" value="{{ $roomtype->max_guests }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label"> Diện tích</label>
            <input type="text" name="area" class="form-control" value="{{ $roomtype->area }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label"> Giá phòng</label>
            <input type="text" name="price" class="form-control" value="{{ $roomtype->price }}" required>
        </div>


        <div class="mb-3">
            <label class="form-label">Các tiện nghi đi cùng</label>
            <textarea name="amenities" class="form-control" required>{{ $roomtype->amenities }}</textarea>
        </div>



        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection