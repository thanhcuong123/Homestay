function openRoutePopup(endLat, endLon) {
    document.getElementById("homestayDetailPopup").style.display = "none";
    document.getElementById("routePopup").style.display = "block";
    // popup.style.display = "none";
    document.getElementById("routePopup").setAttribute("data-end-lat", endLat);
    document.getElementById("routePopup").setAttribute("data-end-lon", endLon);
}

function closeRoutePopup() {
    document.getElementById("routePopup").style.display = "none";
    document.getElementById("homestayDetailPopup").style.display = "block";
    // hiển thị lại popup xem chi
}

document
    .getElementById("startLocation")
    .addEventListener("change", function () {
        let input = document.getElementById("manualInput");
        input.style.display = this.value === "manual" ? "block" : "none";
    });

function calculateRoute() {
    let startOption = document.getElementById("startLocation").value;
    let startLocation = "";

    // Lấy tọa độ homestay từ popup
    let endLat = document
        .getElementById("routePopup")
        .getAttribute("data-end-lat");
    let endLon = document
        .getElementById("routePopup")
        .getAttribute("data-end-lon");
    let homestayLocation = `${endLon},${endLat}`;

    if (startOption === "current") {
        navigator.geolocation.getCurrentPosition((position) => {
            startLocation = `${position.coords.longitude},${position.coords.latitude}`;
            console.log("📍 Bắt đầu từ vị trí hiện tại:", startLocation);
            drawRoute(startLocation, homestayLocation);
        });
    } else if (startOption === "manual") {
        // startLocation = document.getElementById("manualInput").value;
        // console.log("📍 Bắt đầu từ:", startLocation);
        // drawRoute(startLocation, homestayLocation);
        let inputAddress = document.getElementById("manualInput").value;
        if (!inputAddress) {
            alert("Vui lòng nhập địa điểm!");
            return;
        }
        console.log("🔍 Đang tìm tọa độ của:", inputAddress);
        getCoordinatesFromAddress(inputAddress, (coords) => {
            if (!coords) {
                alert("Không tìm thấy địa điểm. Hãy thử nhập lại!");
                return;
            }
            startLocation = `${coords.lng},${coords.lat}`;
            console.log("📍 Bắt đầu từ:", startLocation);
            drawRoute(startLocation, homestayLocation);
        });
    } else if (startOption === "map") {
        alert("Hãy bấm vào bản đồ để chọn điểm bắt đầu!");
        enableMapClickForStartLocation(homestayLocation);
    } else {
        console.log("❌ Chưa chọn điểm bắt đầu!");
    }
}
function enableMapClickForStartLocation(homestayLocation) {
    map.once("click", function (e) {
        let startLocation = `${e.lngLat.lng},${e.lngLat.lat}`;
        console.log("📍 Điểm bắt đầu được chọn trên bản đồ:", startLocation);
        drawRoute(startLocation, homestayLocation);
    });
}
function getCoordinatesFromAddress(address, callback) {
    fetch(
        `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(
            address
        )}.json?access_token=${mapboxgl.accessToken}`
    )
        .then((response) => response.json())
        .then((data) => {
            if (!data.features || data.features.length === 0) {
                console.error("❌ Không tìm thấy địa chỉ!");
                callback(null);
                return;
            }
            let coords = data.features[0].geometry.coordinates;
            callback({ lng: coords[0], lat: coords[1] });
        })
        .catch((error) => {
            console.error("Lỗi khi lấy tọa độ:", error);
            callback(null);
        });
}
function cancelRoute() {
    if (map.getSource("route")) {
        map.removeLayer("route");
        map.removeSource("route");
    }
    document.getElementById("routeInfo").innerHTML = ""; // Xóa thông tin thời gian
    closeRoutePopup();
    console.log("🚫 Đã hủy chỉ đường!");
}

function drawRoute(startLocation, homestayLocation) {
    fetch(
        `https://api.mapbox.com/directions/v5/mapbox/driving/${startLocation};${homestayLocation}?geometries=geojson&access_token=${mapboxgl.accessToken}`
    )
        .then((response) => response.json())
        .then((data) => {
            if (!data.routes || data.routes.length === 0) {
                console.error("❌ Không tìm thấy tuyến đường!");
                return;
            }

            const route = data.routes[0];
            const routeCoords = route.geometry.coordinates;
            const duration = Math.round(route.duration / 60); // phút
            const distance = (route.distance / 1000).toFixed(2); // km

            // Xóa tuyến đường cũ nếu có
            if (map.getSource("route")) {
                map.removeLayer("route");
                map.removeSource("route");
            }

            // Thêm tuyến đường mới
            map.addSource("route", {
                type: "geojson",
                data: {
                    type: "Feature",
                    geometry: {
                        type: "LineString",
                        coordinates: routeCoords,
                    },
                },
            });

            map.addLayer({
                id: "route",
                type: "line",
                source: "route",
                layout: {
                    "line-join": "round",
                    "line-cap": "round",
                },
                paint: {
                    "line-color": "#eb0707",
                    "line-width": 5,
                },
            });

            // Hiển thị khoảng cách & thời gian
            document.getElementById("routeInfo").innerHTML = `
                <p>🚗 Thời gian ước tính: <strong>${duration} phút</strong></p>
                <p>📏 Khoảng cách: <strong>${distance} km</strong></p>
                <button onclick="removeRoute()">❌ Hủy xem đường</button>
            `;

            // Thêm sự kiện hover để hiển thị thông tin khi rê chuột vào tuyến đường
        })
        .catch((error) => console.error("Lỗi khi tìm đường:", error));
}

function removeRoute() {
    if (map.getSource("route")) {
        map.removeLayer("route");
        map.removeSource("route");
    }
    document.getElementById("routeInfo").innerHTML = "";
    document.getElementById("routeHoverInfo").style.display = "none";
}
