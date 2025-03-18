@extends('admin.admin_layout')

@section('title-content')
<title>Thêm Điểm Du Lịch</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2 class="mb-3">Thêm Điểm Du Lịch</h2>

    <form action="{{route('tourist.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tên điểm du lịch</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" id="address" name="address" class="form-control" required>
            <button type="button" class="btn btn-primary mt-2" onclick="getCoordinates()">Lấy tọa độ</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Chọn vị trí trên bản đồ</label>
            <div id="map" style="height: 400px;"></div>
            <p class="mt-2"><i>Nhấp vào bản đồ nếu tọa độ chưa chính xác.</i></p>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

<!-- Nhúng Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ';

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