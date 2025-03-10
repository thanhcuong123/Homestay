<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('user/css/main.css') }}">
    <title>Homestay</title>
</head>

<body>
    <div id="map">
        <div class="search-box">
            <form id="searchForm" action="{{ route('searchHomestay') }}" method="GET">
                <input type="text" id="search" name="query" placeholder="Tên HS hoặc chủ HS">
                <input type="number" name="max_guests" placeholder="Số người ở">
                <input type="number" name="max_price" placeholder="Giá">
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="login-link">
            <a href="{{ route('login') }}">Đăng nhập</a>
        </div>

        @include('user.popup_search')

        {{-- <div id="mapContainer">
            <div id="map">
                <p>Map sẽ hiện ở đây.</p>
            </div>
        </div> --}}
    </div>
    <script src="{{ asset('user/js/search.js') }}"></script>
</body>

</html>
