function viewHomestayDetails(homestayId) {
    console.log("👉 Đang mở popup cho Homestay ID:", homestayId);

    fetch(`/homestay/${homestayId}`)
        .then((response) => response.json())
        .then((homestay) => {
            console.log("✅ Dữ liệu homestay nhận được:", homestay);

            const titleElement = document.getElementById("homestayTitle");
            const infoElement = document.getElementById("homestayInfo");
            const roomsElement = document.getElementById("homestayRooms");
            const reviewsElement = document.getElementById("homestayReviews");
            // const overlay = document.getElementById("homestayDetailOverlay");
            const popup = document.getElementById("homestayDetailPopup");

            if (
                !titleElement ||
                !infoElement ||
                !roomsElement ||
                !reviewsElement ||
                !overlay ||
                !popup
            ) {
                console.error(
                    "⛔ Không tìm thấy phần tử hiển thị thông tin homestay!"
                );
                return;
            }

            // ✅ Tab Thông tin
            titleElement.innerText = homestay.name;
            infoElement.innerHTML = `
                <img src="${homestay.image}" alt="Hình ảnh Homestay" style="width:100%;">
                <p><strong>Địa chỉ:</strong> ${homestay.address}</p>
                <p><strong>Chủ nhà:</strong> ${homestay.owner.name} (${homestay.owner.phone})</p>
                <button
                class="xem-duong-di"
                style="Text-decoration: none;
                        padding: 5px 10px;
                        background: #f8b100;
                        color: #fff;
                        border-radius: 5px;">Xem đường đi</button>
            `;

            // ✅ Tab Loại phòng
            if (Array.isArray(homestay.rooms) && homestay.rooms.length > 0) {
                roomsElement.innerHTML = homestay.rooms
                    .map(
                        (room) => `
                    <div class="room">
                        <h4>${
                            room.name
                        } - ${room.price.toLocaleString()} VND</h4>
                        <p><strong>Số người tối đa:</strong> ${
                            room.max_guests
                        }</p>
                        <p><strong>Diện tích:</strong> ${room.area} m²</p>
                        <p><strong>Tiện nghi:</strong> ${room.amenities}</p>
                    </div>
                `
                    )
                    .join("<hr>");
            } else {
                roomsElement.innerHTML = "<p>Không có thông tin về phòng.</p>";
            }
            // ✅ Tab Đánh giá
            if (
                Array.isArray(homestay.reviews) &&
                homestay.reviews.length > 0
            ) {
                reviewsElement.innerHTML = homestay.reviews
                    .map(
                        (review) => `
                    <div class="review">
                        <p><strong>${review.user}</strong> (${review.rating}⭐)</p>
                        <p>${review.comment}</p>
                    </div>
                `
                    )
                    .join("<hr>");
            } else {
                reviewsElement.innerHTML = "<p>Chưa có đánh giá nào.</p>";
            }
            // Tab du lịch

            console.log("🔥 Đang hiển thị popup...");

            // Hiển thị popup và overlay
            overlay.classList.add("active");
            popup.classList.add("active");
            document.body.classList.add("show-popup");

            console.log("🎉 Popup đã mở!");
        })
        .catch((error) => console.error("Lỗi khi lấy dữ liệu:", error));
}

// Hàm đóng popup
function closeHomestayPopup() {
    console.log("Đóng popup");

    const overlay = document.getElementById("homestayDetailOverlay");
    const popup = document.getElementById("homestayDetailPopup");

    if (overlay && popup) {
        overlay.classList.remove("active");
        popup.classList.remove("active");
    }

    document.body.classList.remove("show-popup");
}

// Chuyển tab
function showTab(tabName) {
    document
        .querySelectorAll(".tab-content")
        .forEach((tab) => tab.classList.remove("active"));
    document
        .querySelectorAll(".tab-btn")
        .forEach((btn) => btn.classList.remove("active"));

    const tabElement = document.getElementById(
        `homestay${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`
    );
    if (tabElement) {
        tabElement.classList.add("active");
    }

    const btnElement = document.querySelector(
        `[onclick="showTab('${tabName}')"]`
    );
    if (btnElement) {
        btnElement.classList.add("active");
    }
}
