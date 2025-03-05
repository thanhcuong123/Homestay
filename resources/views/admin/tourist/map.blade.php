@extends('admin.admin_layout')

@section('title-content')
<title>Bản đồ điểm du lịch</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2>Bản đồ điểm du lịch</h2>
    <div id="map" style="height: 500px;"></div>
</div>

<!-- Thêm Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<div id="mapData"
    data-lat="{{ $latitude }}"
    data-lng="{{ $longitude }}"
    data-name="{{ $name }}"
    data-address="{{ $address }}"
    data-image="{{ $icon ? asset('storage/' . $icon) : asset('default-placeholder.png') }}">
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ';

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

        var marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);

        var popupContent = `
            <div style="text-align: center;">
                <h5>${name}</h5>
                <p>${address}</p>
                ${image ? `<img src="${image}" alt="Tourist Image" style="width: 150px; height: auto; border-radius: 8px;">` : ''}
            </div>
        `;

        var popup = new mapboxgl.Popup({
            offset: 25
        }).setHTML(popupContent);
        marker.setPopup(popup);
        popup.addTo(map);
    });
</script>

@endsection