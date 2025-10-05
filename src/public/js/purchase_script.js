document.addEventListener("DOMContentLoaded", function () {
    const select = document.querySelector(".payment-select");
    const display = document.getElementById("selected-method");
    const form = document.querySelector("form");
    const cardSection = document.getElementById("card-section");

    // Stripe 初期化
    const stripe = Stripe("{{ env('STRIPE_KEY') }}"); // 公開キー
    const elements = stripe.elements();
    const cardElement = elements.create("card");
    cardElement.mount("#card-element");

    // 支払い方法の選択による表示切替
    select.addEventListener("change", function () {
        if (this.value === "1") {
            display.textContent = "コンビニ払い";
            cardSection.style.display = "none";
        } else if (this.value === "2") {
            display.textContent = "カード支払い";
            cardSection.style.display = "block";
        } else {
            display.textContent = "選択してください";
            cardSection.style.display = "none";
        }
    });

    // フォーム送信処理
    form.addEventListener("submit", async function (e) {
        // カード払いの場合のみトークンを作成
        if (select.value === "2") {
            e.preventDefault();

            const { token, error } = await stripe.createToken(cardElement);

            if (error) {
                alert(error.message);
                return;
            }

            // hidden input で stripeToken をフォームに追加
            let hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = "stripeToken";
            hidden.value = token.id;
            form.appendChild(hidden);

            form.submit();
        }
    });
});
