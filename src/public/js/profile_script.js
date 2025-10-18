// タブ切り替えスクリプト
document.querySelectorAll(".tab-link").forEach((button) => {
    button.addEventListener("click", () => {
        // 全てのタブからactiveを外す
        document
            .querySelectorAll(".tab-link")
            .forEach((btn) => btn.classList.remove("active"));
        document
            .querySelectorAll(".tab-content")
            .forEach((content) => content.classList.remove("active"));

        // クリックされたタブをactiveにする
        button.classList.add("active");
        document.getElementById(button.dataset.tab).classList.add("active");
    });
});
