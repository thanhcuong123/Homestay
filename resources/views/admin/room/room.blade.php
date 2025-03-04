@extends('admin.admin_layout')
@section('title-content')
<title>Danh sách phòng </title>
@endsection
@section('main-content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "#28a745",
    }).showToast();
</script>
<div>
    <div class="table-responsive mt-4">
        <h2 class="text-2xl font-bold mb-4">Danh sách phòng Homestay</h2>
        <a href="{{ route('room.create') }}" class="btn btn-success" style="margin-left:4px">Thêm mới</a>


        <table class="table table-bordered table-striped table-fixed">
            <thead class="">
                <tr>
                    <th>Stt</th>
                    <th>Tên loại phòng</th>
                    <th>Số phòng</th>

                    <th>Trạng thái</th>
                    <th>Hình ảnh</th>

                    <th class="sticky-column">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($rooms as $key => $rooms)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $rooms->roomtype-> name}}</td>
                    <td>{{ $rooms->room_number }}</td>
                    <td>{{ $rooms->status}}</td>
                    <td>
                        <img src="{{ asset('storage/'.$rooms->image) }}" style="border-radius: 5px; width:50px; height: 60px;">
                    </td>


                    <td class="sticky-column">
                        <a href="{{ route('room.edit',['id' => $rooms ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('rooms.destroy',$rooms -> id) }}" method="POST" style="display:inline;">
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