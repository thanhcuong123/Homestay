function viewHomestayDetails(homestayId) {
    console.log("👉 Đang mở popup cho Homestay ID:", homestayId);

    fetch(`/homestay/${homestayId}`)
        .then(response => response.json())
        .then(homestay => {
            console.log("✅ Dữ liệu homestay nhận được:", homestay);

            const titleElement = document.getElementById('homestayTitle');
            const infoElement = document.getElementById('homestayInfo');

            if (!titleElement || !infoElement) {
                console.error("⛔ Không tìm thấy phần tử hiển thị thông tin homestay!");
                return;
            }

            titleElement.innerText = homestay.name;
            infoElement.innerHTML = `
                <img src="${homestay.image}" alt="Hình ảnh Homestay" style="width:100%; border-radius: 10px;">
                <p><strong>Địa chỉ:</strong> ${homestay.address}</p>
                <p><strong>Chủ nhà:</strong> ${homestay.owner.name} (${homestay.owner.phone})</p>
            `;

            console.log("🔥 Đang hiển thị popup...");
            document.getElementById('homestayDetailPopup').style.display = "block";
            document.getElementById('homestayDetailOverlay').style.display = "block";
            document.getElementById('homestayDetailPopup').style.bottom = "10%";
            document.getElementById('homestayDetailPopup').style.opacity = "1";
            document.body.classList.add('show-popup');

            console.log("🎉 Popup đã mở!");
        })
        .catch(error => console.error('Lỗi khi lấy dữ liệu:', error));
}

// Hàm đóng popup
function closeHomestayPopup() {
    console.log("Đóng popup");

    document.getElementById("homestayDetailPopup").style.display = "none";
    document.getElementById("homestayDetailOverlay").style.display = "none";

    // Xóa class để reset trạng thái
    document.body.classList.remove('show-popup');
}

// Chuyển tab
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    const tabElement = document.getElementById(`homestay${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`);
    if (tabElement) {
        tabElement.classList.add('active');
    }

    const btnElement = document.querySelector(`[onclick="showTab('${tabName}')"]`);
    if (btnElement) {
        btnElement.classList.add('active');
    }
}
