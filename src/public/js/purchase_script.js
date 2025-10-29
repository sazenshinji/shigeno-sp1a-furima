document.addEventListener("DOMContentLoaded", function () {
    // 支払い方法選択フォームの制御
    const select = document.getElementById("payment-select");
    const methodForm = document.getElementById("method-form");

    if (select && methodForm) {
        let previousValue = select.value;
        select.addEventListener("change", function () {
            const newValue = select.value;
            if (newValue !== previousValue) {
                previousValue = newValue;
                methodForm.submit();
            }
        });
    }

    // Stripe処理（カード・コンビニ共通）
    const form = document.getElementById("payment-form");
    if (!form) return;

    const stripe = Stripe(window.stripePublicKey);

    form.addEventListener("submit", async function (e) {
        const methodInput = form.querySelector('input[name="payment_method"]');
        const method = methodInput ? methodInput.value : "";

        if (!method) {
            // 未選択 → Laravelバリデーション
            return;
        }

        // カード・コンビニ共通でStripeへ
        e.preventDefault();

        try {
            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    payment_method: method,
                    postal_code: form.querySelector('input[name="postal_code"]')
                        .value,
                    address: form.querySelector('input[name="address"]').value,
                    building: form.querySelector('input[name="building"]')
                        .value,
                }),
            });

            const data = await response.json();
            if (data.url) {
                window.location.href = data.url;
            } else {
                alert("Stripeセッションの作成に失敗しました。");
            }
        } catch (error) {
            console.error(error);
            alert("通信エラーが発生しました。");
        }
    });
});
