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
            <input type="text" name="address" id="address" class="form-control" value="{{ $homestay->address }}" required>
            <button type="button" class="btn btn-primary mt-2" onclick="getCoordinates()">Lấy tọa độ</button>
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

        var defaultLocation = [105.7469, 10.0452]; // Mặc định Cần Thơ
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: defaultLocation,
            zoom: 12
        });

        var marker = new mapboxgl.Marker({
                draggable: true
            })
            .setLngLat(defaultLocation)
            .addTo(map);

        function updateLatLng(lng, lat) {
            document.getElementById("longitude").value = lng;
            document.getElementById("latitude").value = lat;
        }

        marker.on('dragend', function() {
            var position = marker.getLngLat();
            updateLatLng(position.lng, position.lat);
        });

        map.on('click', function(event) {
            var lng = event.lngLat.lng;
            var lat = event.lngLat.lat;
            marker.setLngLat([lng, lat]);
            updateLatLng(lng, lat);
        });

        updateLatLng(defaultLocation[0], defaultLocation[1]);

        // Lấy tọa độ từ địa chỉ nhập vào
        window.getCoordinates = function() {
            var address = document.getElementById("address").value;
            if (!address.trim()) {
                alert("Vui lòng nhập địa chỉ!");
                return;
            }

            var url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxgl.accessToken}&country=VN&limit=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.features.length > 0) {
                        var lngLat = data.features[0].center;
                        marker.setLngLat(lngLat);
                        map.flyTo({
                            center: lngLat,
                            zoom: 15
                        });
                        updateLatLng(lngLat[0], lngLat[1]);
                    } else {
                        alert("Không tìm thấy địa chỉ. Vui lòng nhập rõ ràng hơn!");
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        }
    });
</script>

@endsection