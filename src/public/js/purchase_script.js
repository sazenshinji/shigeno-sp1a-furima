document.addEventListener("DOMContentLoaded", function () {
    const select = document.querySelector(".payment-select");
    const form = document.getElementById("payment-form");
    const cardWrapper = document.getElementById("card-element-wrapper");
    const cardElementDiv = document.getElementById("card-element"); // Stripeのマウント先
    const methodDisplay = document.getElementById("selected-method"); // 右側の表示エリア
    const purchaseBtn = document.querySelector(".purchase-btn");
    const hasAddress = document.querySelector(".error-noaddress") === null;

    // Stripe初期化
    const stripe = Stripe(window.stripePublicKey);
    const elements = stripe.elements();
    const cardElement = elements.create("card", {
        hidePostalCode: true, // 郵便番号欄を隠す
        disableLink: true, // 自動入力リンクを無効化
    });
    cardElement.mount("#card-element");

    // 住所がない場合は購入ボタンを無効化
    if (!hasAddress) {
        purchaseBtn.disabled = true;
        purchaseBtn.style.background = "#ccc";
        purchaseBtn.style.cursor = "not-allowed";
    } else {
        purchaseBtn.disabled = false;
        purchaseBtn.style.background = "";
        purchaseBtn.style.cursor = "pointer";
    }

    // 支払い方法の選択で表示と右側の表示を切替
    select.addEventListener("change", function () {
        if (this.value === "1") {
            methodDisplay.textContent = "コンビニ払い";
            cardWrapper.style.display = "none"; // ← ラッパーごと非表示
        } else if (this.value === "2") {
            methodDisplay.textContent = "カード支払い";
            cardWrapper.style.display = "block"; // ← ラッパーごと表示
        } else {
            methodDisplay.textContent = "選択してください";
            cardWrapper.style.display = "none"; // ← ラッパーごと非表示
        }
    });

    // フォーム送信時（カード支払いの場合のみ Stripe 実行）
    form.addEventListener("submit", async function (event) {
        if (select.value === "2") {
            event.preventDefault();

            const { error, paymentIntent } = await stripe.confirmCardPayment(
                window.clientSecret,
                {
                    payment_method: {
                        card: cardElement,
                    },
                }
            );

            if (error) {
                document.getElementById("card-errors").textContent =
                    error.message;
                return;
            }

            if (paymentIntent.status === "succeeded") {
                // hidden input で payment_intent_id をサーバーに渡す
                const hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = "payment_intent_id";
                hidden.value = paymentIntent.id;
                form.appendChild(hidden);

                // フォーム送信
                form.submit();
            }
        }
    });
});
