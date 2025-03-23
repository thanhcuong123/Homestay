function openRoutePopup(endLat, endLon) {
    document.getElementById("routePopup").style.display = "block";

    document.getElementById("routePopup").setAttribute("data-end-lat", endLat);
    document.getElementById("routePopup").setAttribute("data-end-lon", endLon);
}

function closeRoutePopup() {
    document.getElementById("routePopup").style.display = "none";
}


document.getElementById("startLocation").addEventListener("change", function () {
    let input = document.getElementById("manualInput");
    input.style.display = this.value === "manual" ? "block" : "none";
});

function calculateRoute() {
    let startOption = document.getElementById("startLocation").value;
    let startLocation = "";

    // Lấy tọa độ homestay từ popup
    let endLat = document.getElementById("routePopup").getAttribute("data-end-lat");
    let endLon = document.getElementById("routePopup").getAttribute("data-end-lon");
    let homestayLocation = `${endLon},${endLat}`;

    if (startOption === "current") {
        navigator.geolocation.getCurrentPosition((position) => {
            startLocation = `${position.coords.longitude},${position.coords.latitude}`;
            console.log("📍 Bắt đầu từ vị trí hiện tại:", startLocation);
            drawRoute(startLocation, homestayLocation);
        });
    } else if (startOption === "manual") {
        startLocation = document.getElementById("manualInput").value;
        console.log("📍 Bắt đầu từ:", startLocation);
        drawRoute(startLocation, homestayLocation);
    } else {
        console.log("chưa mần nha ní");
    }
}

function drawRoute(startLocation, homestayLocation) {
    console.log("📍 Vẽ tuyến đường từ:", startLocation, "đến:", homestayLocation);

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
            const duration = Math.round(route.duration / 60); // Thời gian di chuyển (phút)

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

            console.log(`🕒 Ước tính thời gian di chuyển: ${duration} phút`);
            document.getElementById(
                "routeInfo"
            ).innerHTML = `<p>🚗 Thời gian ước tính: <strong>${duration} phút</strong></p>`;
        })
        .catch((error) => console.error("Lỗi khi tìm đường:", error));
}
