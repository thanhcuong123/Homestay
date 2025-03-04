@extends('admin.admin_layout')

@section('title-content')
<title>Chỉnh sửa Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa Homestay</h2>

    <form action="{{ route('admin.homestay.update', $homestay->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Chủ Homestay</label>
            <select name="owner_id" class="form-control" required>
                <option value="">-- Chọn chủ homestay --</option>
                @foreach ($owners as $owner)
                <option value="{{ $owner->id }}" {{ $homestay->owner_id == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên Homestay</label>
            <input type="text" name="name" class="form-control" value="{{ $homestay->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ $homestay->address }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if($homestay->image)
            <img src="{{ asset('storage/' . $homestay->image) }}" alt="{{ $homestay->name }}" width="100" height="70" class="mt-2 rounded">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Chọn vị trí trên bản đồ</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $homestay->latitude ?? 10.0452) }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $homestay->longitude ?? 105.7469) }}">


        <div class="mb-3">
            <label class="form-label">Đơn vị hành chính</label>
            <select name="administrative_unit_id" class="form-control">
                <option value="">-- Chọn đơn vị hành chính --</option>
                @foreach ($administrativeUnits as $unit)
                <option value="{{ $unit->id }}" {{ $homestay->administrative_unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

<!-- Nhúng Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ'; // Thay bằng token của bạn

        var defaultLocation = [105.7469, 10.0452]; // Kinh độ, vĩ độ (Mapbox dùng thứ tự khác Leaflet)

        var map = new mapboxgl.Map({
            container: 'map', // ID của phần tử chứa bản đồ
            style: 'mapbox://styles/mapbox/streets-v11', // Kiểu bản đồ
            center: defaultLocation,
            zoom: 12
        });

        // Tạo marker mặc định
        var marker = new mapboxgl.Marker({
                draggable: true
            })
            .setLngLat(defaultLocation)
            .addTo(map);

        // Cập nhật tọa độ khi kéo marker
        function updateLatLng(lng, lat) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        }

        marker.on('dragend', function() {
            var position = marker.getLngLat();
            updateLatLng(position.lng, position.lat);
        });

        // Thêm sự kiện click để chọn vị trí mới
        map.on('click', function(event) {
            var lng = event.lngLat.lng;
            var lat = event.lngLat.lat;

            marker.setLngLat([lng, lat]); // Di chuyển marker đến vị trí click
            updateLatLng(lng, lat);
        });

        // Khởi tạo giá trị mặc định
        updateLatLng(defaultLocation[0], defaultLocation[1]);
    });
</script>

@endsection