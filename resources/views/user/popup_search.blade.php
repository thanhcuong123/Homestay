<div id="overlay" style="display: none;"></div>
<div id="resultsPopup" style="display: none;">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">×</span>
        <h2>Kết quả tìm kiếm</h2>
        <div id="resultsList"></div>
    </div>
</div>


<style>
    #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: 9998;
    display: none;
}

#resultsPopup {
    position: fixed;
    top: 0;
    left: 0;
    width: 400px;
    height: 100%;
    background: #fffbe7;
    padding: 20px;
    border-right: 2px solid #ff7b00;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    display: none;
    animation: slideIn 0.3s ease-in-out;
}

#resultsPopup .popup-content {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

#resultsPopup h2 {
    margin-top: 0;
    font-size: 24px;
    color: #ff7b00;
    text-align: center;
}

#resultsPopup .close-btn {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
    font-size: 24px;
    color: #ff4d4d;
    font-weight: bold;
    transition: color 0.2s ease;
}

#resultsPopup .close-btn:hover {
    color: #ff0000;
}

#resultsList {
    flex-grow: 1;
    overflow-y: auto;
    padding: 10px;
    border-top: 1px solid #ff7b00;
}

/* Hiệu ứng trượt vô */
@keyframes slideIn {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}

</style>
