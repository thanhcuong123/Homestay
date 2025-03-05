@extends('admin.admin_layout')

@section('title-content')
<title>Bản đồ điểm du lịch</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2>Bản đồ điểm du lịch</h2>
    <div id="map" style="height: 500px;"></div>
</div>




<!-- Lưu dữ liệu homestays trong thẻ div ẩn -->
<div id="tourist-data" data-tourist='@json($tourist)'></div>

<!-- Thêm Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [105.7469, 10.0452], // Tọa độ mặc định
            zoom: 6
        });

        // Lấy dữ liệu từ thẻ div ẩn
        var touristData = document.getElementById('tourist-data').getAttribute('data-tourist');

        try {
            var tourist = JSON.parse(touristData); // Chuyển chuỗi JSON thành mảng JavaScript
            tourist.forEach(tourist => {
                if (tourist.latitude && tourist.longitude) {
                    // Tạo nội dung popup chứa hình ảnh
                    var popupContent = `
    <div style="text-align:center;">
        <b>${tourist.name}</b><br>
        <img src="${tourist.icon}" alt="${tourist.icon}" 
             style="width: 150px; height: 100px; border-radius: 8px; object-fit: cover;"><br>
        ${tourist.address}
    </div>
`;

                    new mapboxgl.Marker()
                        .setLngLat([tourist.longitude, tourist.latitude])
                        .setPopup(new mapboxgl.Popup().setHTML(popupContent))
                        .addTo(map);
                }
            });
        } catch (error) {
            console.error("Lỗi khi phân tích JSON:", error);
        }
    });
</script>
@endsection