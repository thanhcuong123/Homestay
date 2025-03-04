@extends('admin.admin_layout')

@section('title-content')
<title>Bản đồ Homestay</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2>Bản đồ Homestay</h2>
    <div id="map" style="height: 500px;"></div>
</div>
<div id="mapData"
    data-lat="{{ $latitude }}"
    data-lng="{{ $longitude }}"
    data-name="{{ $name }}"
    data-address="{{ $address }}"
    data-image="{{ asset('storage/' . $image) }}"></div>

<!-- Thêm Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ'; // Thay bằng Mapbox token của bạn

        var mapElement = document.getElementById("mapData");
        var lat = parseFloat(mapElement.dataset.lat);
        var lng = parseFloat(mapElement.dataset.lng);
        var name = mapElement.dataset.name;
        var address = mapElement.dataset.address;
        var image = mapElement.dataset.image;

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [lng, lat],
            zoom: 15
        });

        // Thêm marker
        var marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);

        // Nội dung popup hiển thị khi click vào marker
        var popupContent = `
            <div style="text-align: center;">
                <h5>${name}</h5>
                <p>${address}</p>
                <img src="${image}" alt="Homestay Image" style="width: 150px; height: auto; border-radius: 8px;">
            </div>
        `;

        // Thêm popup vào marker
        var popup = new mapboxgl.Popup({
            offset: 25
        }).setHTML(popupContent);
        marker.setPopup(popup);

        // Hiển thị popup khi load bản đồ
        popup.addTo(map);
    });
</script>

@endsection