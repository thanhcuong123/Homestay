@extends('admin.admin_layout')

@section('title-content')
<title>Thêm Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm Homestay</h2>

    <form action="{{route('admin.homestay.store')}}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Chủ Homestay</label>
            <select name="owner_id" class="form-control" required>
                <option value="">-- Chọn chủ homestay --</option>
                @foreach ($owners as $owner)
                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên Homestay</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Chọn vị trí trên bản đồ</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <div class="mb-3">
            <label class="form-label">Đơn vị hành chính</label>
            <select name="administrative_unit_id" class="form-control">
                <option value="">-- Chọn đơn vị hành chính --</option>
                @foreach ($administrativeUnits as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

<!-- Nhúng LeafletJS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var defaultLocation = [10.0452, 105.7469];
        var map = L.map('map').setView(defaultLocation, 12);

        // Thêm lớp bản đồ OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker(defaultLocation, {
            draggable: true
        }).addTo(map);

        // Cập nhật giá trị tọa độ khi kéo marker
        function updateLatLng(lat, lng) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        }

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            updateLatLng(position.lat, position.lng);
        });

        // Chọn vị trí khi nhấp vào bản đồ
        map.on('click', function(event) {
            var lat = event.latlng.lat;
            var lng = event.latlng.lng;

            marker.setLatLng([lat, lng]); // Di chuyển marker tới vị trí mới
            updateLatLng(lat, lng);
        });
    });
</script>
@endsection