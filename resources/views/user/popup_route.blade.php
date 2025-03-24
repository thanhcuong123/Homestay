<style>
    #routeHoverInfo {
        display: none;
        position: absolute;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        pointer-events: none;
        z-index: 1000;
        max-width: 200px;
    }

    .khoangcach {
        display: flex;
        gap: 50%;
    }

    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        /* width: 500px;
        height: 300px; */
    }

    .popup-content {
        text-align: center;
    }

    .popup select,
    .popup input {
        width: 100%;
        padding: 8px;
        margin: 10px 0;
    }
</style>

<div id="routePopup" class="popup">



    <div class="popup-content">
        <h2>Chọn điểm bắt đầu</h2>
        <select id="startLocation">
            <option value="current">📍 Vị trí hiện tại</option>
            <option value="map">🗺 Chọn trên bản đồ</option>
            <option value="manual">✍ Nhập địa điểm</option>
        </select>
        <input type="text" id="manualInput" placeholder="Nhập địa điểm" style="display: none;">
        <div class="khoangcach">
            <button onclick="calculateRoute()">Tìm đường</button>
            <button onclick="closeRoutePopup()">Đóng</button>
            <!-- <button onclick="cancelRoute()">Hủy chỉ đường</button> -->
        </div>

        <div id="routeInfo"></div>
        <div id="routeHoverInfo"></div>

    </div>
</div>