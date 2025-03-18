<div id="overlay" style="display: none;"></div>
<div id="resultsPopup" style="display: none;">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">×</span>
        <h2>Kết quả tìm kiếm</h2>
        <div id="resultsList"></div>
    </div>
</div>
@include('user.popup_info')
<script src="{{ asset('user/js/info_homestay.js') }}"></script>


