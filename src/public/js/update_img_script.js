
// image confirmation script
document
    .getElementById("user_image")
    .addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById("preview-image");
                preview.src = e.target.result;
                preview.style.display = "block"; // 選んだら必ず表示
            };
            reader.readAsDataURL(file);
        }
    });
