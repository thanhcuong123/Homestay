document.addEventListener("DOMContentLoaded", function () {
    mapboxgl.accessToken =
        "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ";

    var map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [105.7469, 10.0452],
        zoom: 6,
    });

    var mapData = document.getElementById("map-data");
    var homestays = JSON.parse(mapData.dataset.homestays);
    var touristSpots = JSON.parse(mapData.dataset.touristSpots);

    var startPoint = null;
    var endPoint = null;
    var routePopup = new mapboxgl.Popup({
        closeButton: false,
        closeOnClick: false,
    });

    function addMarkers(data, color, type) {
        data.forEach((location) => {
            if (location.latitude && location.longitude) {
                var popupContent = `
                    <div style="text-align:center;">
                        <b>${location.name}</b><br>
                        <img src="${location.image || location.icon}" 
                            alt="${location.name}" 
                            style="width: 150px; height: 100px; border-radius: 8px; object-fit: cover;"><br>
                        ${location.address}<br>
                        <button onclick="requestStartPoint(${
                            location.latitude
                        }, ${location.longitude}, '${type}')">
                           Tìm đường đi
                        </button>
                    </div>
                `;

                new mapboxgl.Marker({ color: color })
                    .setLngLat([location.longitude, location.latitude])
                    .setPopup(new mapboxgl.Popup().setHTML(popupContent))
                    .addTo(map);
            }
        });
    }

    addMarkers(homestays, "green", "homestay");
    addMarkers(touristSpots, "red", "tourist");

    window.requestStartPoint = function (lat, lon, type) {
        endPoint = [lon, lat];
        alert("Vui lòng chọn điểm bắt đầu bằng cách click vào bản đồ!");

        map.once("click", function (e) {
            startPoint = [e.lngLat.lng, e.lngLat.lat];

            new mapboxgl.Popup()
                .setLngLat(startPoint)
                .setHTML("<b>Điểm bắt đầu</b>")
                .addTo(map);

            calculateRoute();
        });
    };

    function calculateRoute() {
        if (!startPoint || !endPoint) {
            alert("Vui lòng chọn điểm bắt đầu và điểm đến!");
            return;
        }

        var url = `https://api.mapbox.com/directions/v5/mapbox/driving/${startPoint[0]},${startPoint[1]};${endPoint[0]},${endPoint[1]}?access_token=${mapboxgl.accessToken}&geometries=geojson`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var route = data.routes[0].geometry;
                var distance = (data.routes[0].distance / 1000).toFixed(2);
                var duration = (data.routes[0].duration / 60).toFixed(2);

                new mapboxgl.Popup()
                    .setLngLat(endPoint)
                    .setHTML(
                        `<b>Khoảng cách:</b> ${distance} km<br><b>Thời gian:</b> ${duration} phút`
                    )
                    .addTo(map);

                if (map.getSource("route")) {
                    map.removeLayer("route");
                    map.removeSource("route");
                }

                map.addSource("route", {
                    type: "geojson",
                    data: {
                        type: "Feature",
                        properties: { distance, duration },
                        geometry: route,
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
                        "line-color": "#ff0000",
                        "line-width": 5,
                    },
                });

                map.on("mousemove", function (e) {
                    var features = map.queryRenderedFeatures(e.point, {
                        layers: ["route"],
                    });

                    if (features.length) {
                        var props = features[0].properties;
                        routePopup
                            .setLngLat(e.lngLat)
                            .setHTML(
                                `<b>Khoảng cách:</b> ${distance} km<br><b>Thời gian:</b> ${duration} phút`
                            )
                            .addTo(map);
                    } else {
                        routePopup.remove();
                    }
                });
            })
            .catch((error) => console.error("Lỗi:", error));
    }
});
