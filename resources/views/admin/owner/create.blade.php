@extends('admin.admin_layout')

@section('title-content')
<title>Thêm Chủ Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm Chủ Homestay</h2>

    <form action="{{route('admin.owner.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên Chủ Homestay</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-control" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>



        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection