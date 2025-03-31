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
            const touristElement = document.getElementById("homestayTourists");
            //const overlay = document.getElementById("homestayDetailOverlay");
            const popup = document.getElementById("homestayDetailPopup");

            if (
                !titleElement ||
                !infoElement ||
                !roomsElement ||
                !reviewsElement ||
                !touristElement ||
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
                <button class="xem-duong-di"
                    data-lat="${homestay.latitude}"
                    data-lon="${homestay.longitude}"
                    style="text-decoration: none;
                        padding: 5px 10px;
                        background: #f8b100;
                        color: #fff;
                        border-radius: 5px;">
                    Xem đường đi
                </button>
            `;

            //chuyển hướng xem đường đi
            document
                .querySelector(".xem-duong-di")
                .addEventListener("click", function () {
                    let lat = this.dataset.lat;
                    let lon = this.dataset.lon;
                    console.log(
                        "🌍 Đang hiển thị popup xem đường đi:",
                        lat,
                        lon
                    );
                    openRoutePopup(lat, lon);
                });

            // ✅ Tab Loại phòng
            if (Array.isArray(homestay.rooms) && homestay.rooms.length > 0) {
                roomsElement.innerHTML = homestay.rooms
                    .map(
                        (room) => `
                    <div class="room">
                        <h4>${
                            room.name
                        } - giá phòng ${room.price.toLocaleString()} VND</h4>
                        <p><strong>Số người tối đa:</strong> ${
                            room.max_guests
                        } người</p>
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
            //js đánh giá xử lí riêng
            // if (
            //     Array.isArray(homestay.reviews) &&
            //     homestay.reviews.length > 0
            // ) {
            //     reviewsElement.innerHTML = homestay.reviews
            //         .map((review) => {
            //             // Hiển thị số sao dưới dạng ký tự ⭐
            //             let stars = "⭐".repeat(review.rating);

            //             return `
            //             <div class="review">
            //                 <div class="review-header">
            //                     <img src="${
            //                         review.avatar
            //                             ? review.avatar
            //                             : "storage/uploads/icon/an_danh.jpg"
            //                     }" alt="Ảnh đại diện" class="review-avatar">
            //                     <p><strong>${review.user_name}</strong></p>
            //                     <p class="stars">${stars}</p>
            //                 </div>
            //                 <p>${review.comment}</p>
            //             </div>
            //         `;
            //         })
            //         .join("<hr>");
            // } else {
            //     reviewsElement.innerHTML = "<p>Chưa có đánh giá nào.</p>";
            // }

            // ✅ Tab Đánh giá

            reviewsElement.innerHTML = `
<button id="btnAddReview" style="text-decoration: none;
                        padding: 5px 10px;
                        background: #f8b100;
                        color: #fff;
                        border-radius: 5px;">Thêm đánh giá</button>
<div id="reviewForm" style="display: none; margin-bottom: 10px;">
    <textarea id="reviewComment" placeholder="Nhập đánh giá của bạn" rows="3" style="width: 100%;"></textarea>
    <br>
    <label for="reviewRating">Chọn số sao:</label>
    <select id="reviewRating">
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
    </select>
    <br>
    <button id="submitReview" style="text-decoration: none;
                        padding: 5px 10px;
                        background: #f8b100;
                        color: #fff;
                        border-radius: 5px;">Gửi đánh giá</button>
</div>
${
    homestay.reviews.length > 0
        ? homestay.reviews
              .map((review) => {
                  let stars = "⭐".repeat(review.rating);
                  return `
        <div class="review">
            <div class="review-header">
                <img src="${
                    review.avatar || "storage/uploads/icon/an_danh.jpg"
                }" alt="Ảnh đại diện" class="review-avatar">
                <p><strong>${review.user_name}</strong></p>
                <p class="stars">${stars}</p>
            </div>
            <p>${review.comment}</p>
        </div>
    `;
              })
              .join("<hr>")
        : "<p>Chưa có đánh giá nào.</p>"
}
`;

            document
                .getElementById("submitReview")
                .addEventListener("click", function () {
                    let isLoggedIn =
                        document
                            .querySelector('meta[name="user-auth"]')
                            .getAttribute("content") === "true";

                    if (!isLoggedIn) {
                        alert("Bạn cần đăng nhập để đánh giá!");
                        return;
                    }

                    let comment =
                        document.getElementById("reviewComment").value;
                    let rating = document.getElementById("reviewRating").value;
                    let csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");

                    if (!comment.trim()) {
                        alert("Vui lòng nhập nội dung đánh giá!");
                        return;
                    }

                    let newReview = {
                        homestay_id: homestay.id,
                        rating: parseInt(rating),
                        comment: comment,
                    };

                    fetch("/reviews", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify(newReview),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.message) {
                                alert("Cảm ơn bạn đã đánh giá!");
                                homestay.reviews.push(data.review);
                                viewHomestayDetails(homestay.id);
                            } else {
                                alert("Lỗi khi lưu đánh giá!");
                            }
                        })
                        .catch((error) => console.error("Lỗi:", error));
                });

            // Xử lý hiển thị form đánh giá khi bấm vào nút
            document
                .getElementById("btnAddReview")
                .addEventListener("click", function () {
                    let isLoggedIn =
                        document
                            .querySelector('meta[name="user-auth"]')
                            .getAttribute("content") === "true";

                    if (isLoggedIn) {
                        document.getElementById("reviewForm").style.display =
                            "block";
                    } else {
                        alert("Bạn cần đăng nhập để đánh giá!");
                        window.location.href = "/login";
                    }
                });

            // loadReviews(homestayId);

            // Tab du lịch
            // ✅ Tab Điểm du lịch gần đây (SỬA LỖI)
            if (
                Array.isArray(homestay.tourist_spots) &&
                homestay.tourist_spots.length > 0
            ) {
                // const nearbySpots = homestay.tourist_spots.filter(spot => spot.distance <= 5);
                const nearbySpots = homestay.tourist_spots;

                if (nearbySpots.length > 0) {
                    touristElement.innerHTML = nearbySpots
                        .map(
                            (spot) => `
                        <div class="tourist-spot">
                            <h4>${spot.name}</h4>
                    <img src="${spot.icon}" alt="Hình ảnh Homestay" style="margin-left:17px; width:85%;height=80%">
                            <p><strong>Địa chỉ:</strong> ${spot.address}</p>
                            <p><strong>Khoảng cách:</strong> ${spot.distance} </p>
                            <button class="xem-duong-di"
                                data-lat="${spot.latitude}"
                                data-lon="${spot.longitude}"
                                style="text-decoration: none;
                                    padding: 5px 10px;
                                    background: #28a745;
                                    color: #fff;
                                    border-radius: 5px;">
                                Xem đường đi
                            </button>
                        </div>
                    `
                        )
                        .join("<hr>");
                } else {
                    touristElement.innerHTML =
                        "<p>Không có địa điểm du lịch nào trong vòng 5km.</p>";
                }
            } else {
                touristElement.innerHTML =
                    "<p>Không có thông tin về địa điểm du lịch.</p>";
            }

            // Sự kiện click cho tất cả nút "Xem đường đi"
            document
                .querySelectorAll(".tourist-spot .xem-duong-di")
                .forEach((button) => {
                    button.addEventListener("click", function () {
                        let spotLat = this.dataset.lat; // Lấy lat của địa điểm du lịch
                        let spotLon = this.dataset.lon; // Lấy lon của địa điểm du lịch

                        let homeLat = homestay.latitude; // Lấy lat của homestay hiện tại
                        let homeLon = homestay.longitude; // Lấy lon của homestay hiện tại

                        console.log(
                            "🚗 Hiển thị đường đi từ homestay đến địa điểm du lịch:",
                            homeLat,
                            homeLon,
                            "➡",
                            spotLat,
                            spotLon
                        );

                        // Gọi Mapbox để hiển thị đường đi
                        showRouteOnMap(homeLat, homeLon, spotLat, spotLon);
                    });
                });

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

    document.getElementById("homestayInfo").innerHTML = "";
    document.getElementById("homestayRooms").innerHTML = "";
    document.getElementById("homestayReviews").innerHTML = "";
    document.getElementById("homestayTourists").innerHTML = "";

    document.body.classList.remove("show-popup");
}

// Chuyển tab
function showTab(tabName) {
    document.querySelectorAll(".tab-content").forEach((tab) => {
        tab.classList.remove("active");
        tab.style.display = "none"; // Ẩn tất cả tab
    });

    document
        .querySelectorAll(".tab-btn")
        .forEach((btn) => btn.classList.remove("active"));

    const tabElement = document.getElementById(
        `homestay${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`
    );

    console.log("Tab cần mở:", tabElement);
    console.log(
        "Nội dung tab:",
        tabElement ? tabElement.innerHTML : "Không tìm thấy tab"
    );

    if (tabElement) {
        tabElement.classList.add("active");
        tabElement.style.display = "block"; // Đảm bảo nó hiển thị
    } else {
        console.error("Không tìm thấy tab:", tabName);
    }

    const btnElement = document.querySelector(
        `[onclick="showTab('${tabName}')"]`
    );

    if (btnElement) {
        btnElement.classList.add("active");
    }
}
