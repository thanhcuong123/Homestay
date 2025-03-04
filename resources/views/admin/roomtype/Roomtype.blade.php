@extends('admin.admin_layout')
@section('title-content')
<title>Quản lí loại phòng</title>
@endsection

@section('main-content')
<div>
    <div class="table-responsive mt-4">
        <h2 class="text-2xl font-bold mb-4">Danh sách loại phòng Homestay</h2>
        <a href="{{ route('roomtype.create') }}" class="btn btn-success" style="margin-left:4px">Thêm mới</a>


        <table class="table table-bordered table-striped table-fixed">
            <thead class="">
                <tr>
                    <th>Stt</th>
                    <th>Tên homestay</th>
                    <th>Tên loại</th>
                    <th> Số người</th>
                    <th>Diện tích</th>
                    <th>Giá</th>
                    <th>Tiện nghi</th>

                    <th class="sticky-column">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($rooms as $key => $rooms)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $rooms->homestay-> name}}</td>
                    <td>{{ $rooms->name }}</td>
                    <td>{{ $rooms->max_guests}}</td>
                    <td>{{ $rooms->area }}</td>
                    <td>{{ $rooms->price }}</td>
                    <td>{{ $rooms->amenities }}</td>

                    <td class="sticky-column">
                        <a href="{{ route('roomtype.edit',['id' => $rooms ->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('roomtype.destroy',$rooms -> id) }}" method="POST" style="display:inline;">
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