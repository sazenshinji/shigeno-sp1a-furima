document.addEventListener("DOMContentLoaded", function () {
    const select = document.querySelector(".payment-select");
    const methodDisplay = document.getElementById("selected-method");

    // 支払い方法の切り替え表示
    select.addEventListener("change", function () {
        if (this.value === "1") {
            methodDisplay.textContent = "コンビニ払い";
        } else if (this.value === "2") {
            methodDisplay.textContent = "カード支払い";
        } else {
            methodDisplay.textContent = "選択してください";
        }
    });

    // 初期反映
    if (select.value) {
        select.dispatchEvent(new Event("change"));
    }
});
