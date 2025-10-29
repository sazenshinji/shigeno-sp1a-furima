document.getElementById("image").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById("preview");
    const placeholder = document.getElementById("image-placeholder");
    const imageBox = document.querySelector(".image-upload-box"); // ← 追加：枠の要素を取得

    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            // 画像を表示
            preview.src = event.target.result;
            preview.style.display = "block";
            // 「画像を選択する」テキストを非表示
            placeholder.style.display = "none";
            // 画像アップロード後に枠を非表示
            imageBox.classList.add("no-border");
        };
        reader.readAsDataURL(file);
    } else {
        // ファイル未選択の場合（再選択なし）
        preview.src = "";
        preview.style.display = "none";
        placeholder.style.display = "block";
        // 枠を再表示
        imageBox.classList.remove("no-border");
    }
});
