document.addEventListener("DOMContentLoaded", function () {
    console.log(" Review.js đã được tải!");

    window.loadReviews = function (homestayId) {
        fetch(`/homestay/${homestayId}/reviews`)
            .then((response) => response.json())
            .then((reviews) => {
                console.log(" Dữ liệu API:", reviews);
                const reviewList = document.getElementById("reviewList");

                if (
                    Array.isArray(homestay.reviews) &&
                    homestay.reviews.length > 0
                ) {
                    reviewsElement.innerHTML = homestay.reviews
                        .map((review) => {
                            // Hiển thị số sao dưới dạng ký tự ⭐
                            let stars = "⭐".repeat(review.rating);

                            return `
                            <div class="review">
                                <div class="review-header">
                                    <img src="${
                                        review.avatar
                                            ? review.avatar
                                            : "storage/uploads/icon/an_danh.jpg"
                                    }" alt="Ảnh đại diện" class="review-avatar">
                                    <p><strong>${review.user_name}</strong></p>
                                    <p class="stars">${stars}</p>
                                </div>
                                <p>${review.comment}</p>
                            </div>
                        `;
                        })
                        .join("<hr>");
                } else {
                    reviewsElement.innerHTML = "<p>Chưa có đánh giá nào.</p>";
                }
            })
            .catch((error) => console.error("⛔ Lỗi khi tải đánh giá:", error));
    };

    // Xử lý gửi đánh giá
    const reviewForm = document.getElementById("reviewForm");
    if (reviewForm) {
        reviewForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const homestayId =
                document.getElementById("reviewHomestayId").value;
            const userName = document.getElementById("userName").value;
            const rating = document.getElementById("rating").value;
            const content = document.getElementById("content").value;
            fetch("/reviews", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    homestay_id: homestayId,
                    user_name: userName,
                    rating: rating,
                    content: content,
                }),
            })
                .then((response) => response.json())
                .then(() => {
                    alert("Cảm ơn bạn đã đánh giá!");
                    loadReviews(homestayId);
                    reviewForm.reset();
                })
                .catch((error) =>
                    console.error("⛔ Lỗi khi gửi đánh giá:", error)
                );
        });
    }
});
