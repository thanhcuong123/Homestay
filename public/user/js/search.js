mapboxgl.accessToken =
    "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ"; // Thay bằng token của bạn
const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: [105.7680404, 10.0299337],
    zoom: 12,
});

document
    .getElementById("searchForm")
    .addEventListener("submit", function (event) {
        event.preventDefault(); // Ngăn form load lại trang

        const formData = new FormData(this);
        const params = new URLSearchParams(formData).toString();

        fetch(`/search-homestay?${params}`)
            .then((response) => response.json())
            .then((data) => {
                console.log("✅ Dữ liệu JSON nhận được:", data);
                showResultsPopup(data);
                updateMap(data);
            })
            .catch((error) => console.error("Lỗi:", error));
    });

let markers = [];

function updateMap(homestays) {
    markers.forEach((marker) => marker.remove());
    markers = [];

    if (homestays.length === 0) {
        console.warn("🚫 Không tìm thấy homestay nào.");
        return;
    }

    homestays.forEach((homestay, index) => {
        if (homestay.latitude && homestay.longitude) {
            let iconUrl = "/storage/uploads/icon/home-icon.png";
            const el = document.createElement("div");
            el.className = "custom-marker";
            el.style.backgroundImage = `url(${iconUrl})`;
            el.style.width = "40px";
            el.style.height = "40px";
            el.style.backgroundSize = "cover";
            el.style.borderRadius = "50%";
            const marker = new mapboxgl.Marker(el) // ✅ Gán element vào marker
                .setLngLat([homestay.longitude, homestay.latitude])
                .setPopup(
                    new mapboxgl.Popup().setHTML(`
                <div style="text-align:center;">
                    <h3>${homestay.name}</h3>
                    <p>${homestay.address}</p>
                </div>
            `)
                )
                .addTo(map);

            // Lưu marker vào danh sách để dễ xóa sau này
            markers.push(marker);
            marker.getElement().addEventListener("click", () => {
                showResultsPopup(homestays);
            });

            // 🔥 Nếu là homestay đầu tiên, tự động di chuyển đến đó
            if (homestays.length > 0) {
                let firstHomestay = homestays[0];
                map.flyTo({
                    center: [firstHomestay.longitude, firstHomestay.latitude],
                    zoom: 14,
                    essential: true,
                });
            }
        }
    });
}

// xử lý popup
function showResultsPopup(results) {
    const resultsList = document.getElementById("resultsList");
    resultsList.innerHTML = "";

    if (results.length === 0) {
        resultsList.innerHTML = "<p>Không tìm thấy homestay phù hợp.</p>";
    } else {
        results.forEach((homestay) => {
            resultsList.innerHTML += `
                <div>
                    <h3>${homestay.name}</h3>
                    <img src="${homestay.image}" alt="Hình ảnh Homestay" style="margin-left:17px; width:85%;height=80%">
                    <p>Địa chỉ: ${homestay.address}</p>
                    <p>Chủ nhà: ${homestay.owner.name} (${homestay.owner.phone})</p>
                    <button class="xem-chi-tiet" data-id="${homestay.id}"
                    style = "Text-decoration: none;
                        padding: 5px 10px;
                        background: #69ae8b;
                        color: #fff;
                        border-radius: 5px;">
                        Xem chi tiết</button>
                    <hr>
                </div>
            `;
        });
    }

    // document.getElementById("overlay").style.display = "block";
    document.getElementById("resultsPopup").style.display = "block";

    document.querySelectorAll(".xem-chi-tiet").forEach((button) => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;
            if (!id) {
                console.error("Lỗi: ID không tồn tại");
                return;
            }
            console.log(
                " Đang hiển thị popup với dữ liệu có sẵn cho Homestay ID:",
                id
            );
            viewHomestayDetails(id);
        });
    });
}

function closePopup() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("resultsPopup").style.display = "none";
}
