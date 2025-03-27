@extends('admin.admin_layout')

@section('title-content')
<title>Bản đồ Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2>Bản đồ Homestay</h2>
    <div id="map" style="height: 500px;"></div>
</div>




<!-- Lưu dữ liệu homestays trong thẻ div ẩn -->
<div id="homestay-data" data-homestays='@json($homestays)'></div>

<!-- Thêm Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [105.7680404, 10.0299337], // Tọa độ mặc định
            zoom: 6
        });

        // Lấy dữ liệu từ thẻ div ẩn
        var homestayData = document.getElementById('homestay-data').getAttribute('data-homestays');

        try {
            var homestays = JSON.parse(homestayData); // Chuyển chuỗi JSON thành mảng JavaScript
            homestays.forEach(homestay => {
                if (homestay.latitude && homestay.longitude) {
                    // Tạo nội dung popup chứa hình ảnh
                    var popupContent = `
    <div style="text-align:center;">
        <b>${homestay.name}</b><br>
        <img src="${homestay.image}" alt="${homestay.name}"
             style="width: 150px; height: 100px; border-radius: 8px; object-fit: cover;"><br>
        ${homestay.address}
    </div>
`;


                    new mapboxgl.Marker()
                        .setLngLat([homestay.longitude, homestay.latitude])
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
