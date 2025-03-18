document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn form load lại trang

    const formData = new FormData(this);
    const params = new URLSearchParams(formData).toString();

    fetch(`/search-homestay?${params}`)
        .then(response => response.json())
        .then(data => {
            showResultsPopup(data);
        })
        .catch(error => console.error('Lỗi:', error));
});

// xử lý popup
function showResultsPopup(results) {
    const resultsList = document.getElementById('resultsList');
    resultsList.innerHTML = '';

    if (results.length === 0) {
        resultsList.innerHTML = '<p>Không tìm thấy homestay phù hợp.</p>';
    } else {
        results.forEach(homestay => {
            resultsList.innerHTML += `
                <div>
                    <h3>${homestay.name}</h3>
                    <p>Địa chỉ: ${homestay.address}</p>
                    <p>Chủ nhà: ${homestay.owner.name} (${homestay.owner.phone})</p>
                    <button class="xem-chi-tiet" data-id="${homestay.id}">Xem chi tiết</button>
                    <hr>
                </div>
            `;
        });
    }

    document.getElementById('overlay').style.display = 'block';
    document.getElementById('resultsPopup').style.display = 'block';

    document.querySelectorAll(".xem-chi-tiet").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;
            if (!id) {
                console.error("Lỗi: ID không tồn tại");
                return;
            }

            console.log("Đang mở popup cho Homestay ID:", id);

            fetch(`/homestay/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert("Lỗi: " + data.error);
                        return;
                    }

                    // Cập nhật thông tin trong popup
                    document.getElementById("homestayTitle").innerText = data.name;
                    document.getElementById("homestayInfo").innerHTML = `
                        <p>Địa chỉ: ${data.address}</p>
                        <p>Chủ nhà: ${data.owner.name}</p>
                        <img src="${data.image}" width="200">
                    `;

                    // Hiển thị popup
                    document.getElementById("homestayDetailOverlay").style.display = "block";
                    document.getElementById("homestayDetailPopup").style.display = "block";
                })
                .catch(error => console.error("Lỗi:", error));
        });
    });
}

function closePopup() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('resultsPopup').style.display = 'none';
}
