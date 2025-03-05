@extends('admin.admin_layout')

@section('title-content')
<title>Thêm Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm Homestay</h2>

    <form action="{{route('tourist.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tên điểm du lịch</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Chọn vị trí trên bản đồ</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

<!-- Nhúng LeafletJS -->
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