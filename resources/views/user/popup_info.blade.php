<!-- Overlay -->
<div id="homestayDetailOverlay" class="overlay"></div>
<style>
    #homestayTourists {
        max-height: 600px;
        /* Giới hạn chiều cao */
        overflow-y: auto;
        /* Bật thanh cuộn dọc */
        padding: 10px;
        /* Thêm padding để không bị che khuất */
        border: 1px solid #ddd;
        /* Tạo viền nhẹ để dễ phân biệt */
        background: #fff;
        /* Giữ màu nền rõ ràng */
    }

    .review-avatar {
        width: 50px;
    }
</style>
<!-- Popup -->
<div id="homestayDetailPopup" class="homestay-popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeHomestayPopup()">×</span>
        <h2 id="homestayTitle">Thông tin Homestay</h2>
        <div class="tab-buttons">
            <button onclick="showTab('info')" class="tab-btn active">Thông tin</button>
            <button onclick="showTab('rooms')" class="tab-btn">Loại phòng</button>
            <button onclick="showTab('reviews')" class="tab-btn">Đánh giá</button>
            <div class="popup-content">
                <button onclick="showTab('tourists')" class="tab-btn">Điểm du lịch gần đây</button>
            </div>
        </div>

        <div id="homestayInfo" class="tab-content active"></div>
        <div id="homestayRooms" class="tab-content"></div>
        <div id="homestayReviews" class="tab-content">
            <h3>Để lại đánh giá</h3>
            <form id="reviewForm">
                <input type="hidden" id="reviewHomestayId">
                <label for="userName">Tên của bạn:</label>
                <input type="text" id="userName" required>
                <label for="rating">Chọn đánh giá:</label>
                <select id="rating" required>
                    <option value="5">⭐️⭐️⭐️⭐️⭐️ - Tuyệt vời</option>
                    <option value="4">⭐️⭐️⭐️⭐️ - Tốt</option>
                    <option value="3">⭐️⭐️⭐️ - Bình thường</option>
                    <option value="2">⭐️⭐️ - Không tốt</option>
                    <option value="1">⭐️ - Rất tệ</option>
                </select>
                <label for="comment">Nhận xét:</label>
                <textarea id="comment" required></textarea>
                <button type="submit">Gửi đánh giá</button>
            </form>
            <h3>Đánh giá từ khách hàng</h3>
            <div id="reviewList"></div>
        </div>
        <div class="popup-content">
            <div id="homestayTourists" class="tab-content"></div>
        </div>
    </div>
</div>

@include('user.popup_route')
<script src="{{ asset('user/js/route.js') }}"></script>
