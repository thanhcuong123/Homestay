@extends('admin.admin_layout')

@section('title-content')
<title>Bản đồ tổng hợp</title>
@endsection

@section('main-content')
<div class="container mt-4">
    <h2>Bản đồ Homestay & Điểm Du Lịch</h2>
    <div id="map" style="height: 600px;"></div>
</div>

<!-- Lưu dữ liệu vào thẻ div ẩn -->
<div id="map-data"
    data-homestays='@json($homestays)'
    data-tourist-spots='@json($touristSpots)'>
</div>

<!-- Thêm Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<script src="{{ asset('system/script.js') }}"></script>
@endsection