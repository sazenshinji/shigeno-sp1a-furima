document.addEventListener("DOMContentLoaded", function () {
    const select = document.querySelector(".payment-select");
    const display = document.getElementById("selected-method");

    select.addEventListener("change", function () {
        if (this.value === "1") {
            display.textContent = "コンビニ払い";
        } else if (this.value === "2") {
            display.textContent = "カード支払い";
        } else {
            display.textContent = "選択してください";
        }
    });
});
