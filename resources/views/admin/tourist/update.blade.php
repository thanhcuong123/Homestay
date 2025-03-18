@extends('admin.admin_layout')

@section('title-content')
<title>Chỉnh sửa Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Chỉnh sửa Homestay</h2>

    <form action="{{ route('tourist.update', $tourist->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên điểm du lịch</label>
            <input type="text" name="name" class="form-control" value="{{ $tourist->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ $tourist->address }}" required>
        </div>

        <button type="button" class="btn btn-primary mb-3" id="getCoordinates">Lấy tọa độ</button>

        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if($tourist->icon)
            <img src="{{ asset('storage/' . $tourist->icon) }}" alt="{{ $tourist->name }}" width="100" height="70" class="mt-2 rounded">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Vị trí trên bản đồ</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $tourist->latitude ?? 10.0452) }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $tourist->longitude ?? 105.7469) }}">

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

<!-- Nhúng Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ';
        var defaultLocation = [105.7469, 10.0452];
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
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
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

        document.getElementById("getCoordinates").addEventListener("click", function() {
            var address = document.getElementById("address").value;
            if (address.trim() !== "") {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxgl.accessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.features.length > 0) {
                            var location = data.features[0].center;
                            marker.setLngLat(location);
                            map.flyTo({
                                center: location,
                                zoom: 14
                            });
                            updateLatLng(location[0], location[1]);
                        } else {
                            alert("Không tìm thấy tọa độ cho địa chỉ này.");
                        }
                    })
                    .catch(error => console.error("Lỗi khi lấy tọa độ:", error));
            } else {
                alert("Vui lòng nhập địa chỉ trước khi lấy tọa độ.");
            }
        });
    });
</script>
@endsection