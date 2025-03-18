<div id="homestayDetailOverlay" class="overlay" style="display: none;"></div>

<div id="homestayDetailPopup" class="homestay-popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeHomestayPopup()">×</span>
        <h2 id="homestayTitle">Thông tin Homestay</h2>

        <div class="tab-buttons">
            <button onclick="showTab('info')" class="tab-btn active">Thông tin</button>
            <button onclick="showTab('rooms')" class="tab-btn">Loại phòng</button>
            <button onclick="showTab('reviews')" class="tab-btn">Đánh giá</button>
        </div>

        <div id="homestayInfo" class="tab-content active"></div>
        <div id="homestayRooms" class="tab-content"></div>
        <div id="homestayReviews" class="tab-content"></div>
    </div>
</div>
