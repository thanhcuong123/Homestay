<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('user/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/info_homestay.css') }}">
    <title>Homestay</title>
</head>

<body>
    <div id="map">
        <div class="search-box">
            <form id="searchForm" action="{{ route('searchHomestay') }}" method="GET">
                <input type="text" id="search" name="query" placeholder="Tìm kiếm">
                <!-- <input type="number" name="max_guests" placeholder="Số người ở">
                <input type="number" name="max_price" placeholder="Giá"> -->
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="login-link">
            @if(Auth::check())
            <span><strong>Xin chào, {{ Auth::user()->name }}!</strong> </span>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            <a href="{{ route('login') }}">Đăng nhập</a>
            @endif
        </div>

        @include('user.popup_search')
        <div id="map-data">
        </div>
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    </div>
    <script src="{{ asset('user/js/search.js') }}"></script>
    <script src="{{ asset('user/js/info_homestay.js') }}"></script>
    <script src="{{ asset('user/js/route.js') }}" ></script>
    <script src="{{ asset('user/js/review.js') }}"
    <!-- <script src="{{ asset('system/script.js')}}"></script> -->

</body>

</html>
