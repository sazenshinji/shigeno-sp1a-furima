document.addEventListener("DOMContentLoaded", function () {
    const likeBtn = document.querySelector(".like-btn");
    if (likeBtn) {
        likeBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const productId = this.dataset.productId;

            fetch(`/products/${productId}/like`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    const likeIcon = this.querySelector(".like-icon");
                    const likeCount = document.getElementById("like-count");

                    likeIcon.src = data.liked
                        ? "/storage/images/21_star_red.png"
                        : "/storage/images/21_star.png";

                    likeCount.textContent = data.count;
                })
                .catch((err) => console.error(err));
        });
    }
});
