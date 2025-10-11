// プロフィール画像プレビュー + グレー丸制御スクリプト
document.getElementById("user_image").addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("preview-image");
    const placeholder = document.querySelector(".placeholder-circle");

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // プレビュー画像を表示
            preview.src = e.target.result;
            preview.style.display = "block";

            // グレーの丸を非表示にする
            if (placeholder) {
                placeholder.style.display = "none";
            }
        };
        reader.readAsDataURL(file);
    } else {
        // ファイル未選択のときはグレー丸を再表示し、プレビューを非表示
        if (placeholder) {
            placeholder.style.display = "block";
        }
        preview.style.display = "none";
        preview.src = "";
    }
});