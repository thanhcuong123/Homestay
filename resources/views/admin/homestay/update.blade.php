@extends('admin.admin_layout')

@section('title-content')
<title>Chỉnh sửa Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa Homestay</h2>

    <form action="{{ route('admin.homestay.update', $homestay->id) }}" method="POST">
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

<!-- Nhúng LeafletJS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var latitude = document.getElementById("latitude").value;
        var longitude = document.getElementById("longitude").value;
        var defaultLocation = [latitude, longitude];

        var map = L.map('map').setView(defaultLocation, 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker(defaultLocation, {
            draggable: true
        }).addTo(map);

        function updateLatLng(lat, lng) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        }

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            updateLatLng(position.lat, position.lng);
        });

        map.on('click', function(event) {
            var lat = event.latlng.lat;
            var lng = event.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateLatLng(lat, lng);
        });
    });
</script>

@endsection