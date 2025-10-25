<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;

class K_PurchasePaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_支払い方法選択機能()
    {
        // user_id=3でログイン
        $user = \App\Models\User::find(3);
        $this->actingAs($user);

        // product_id=4（革靴）
        $product = \App\Models\Product::find(4);

        //初期状態（未選択）で購入画面を開く
        $response = $this->get(route('products.purchase', $product->id));
        $response->assertStatus(200);
        $response->assertSee('選択してください');

        //「コンビニ払い」を選択してPOST送信
        $response = $this->post(route('products.purchase.method', $product->id), [
            'payment_method' => 1,
        ]);

        // セッションに保存されていることを確認
        $this->assertEquals(1, session('selected_payment_method'));

        // リダイレクト後の表示確認
        $response = $this->get(route('products.purchase', $product->id));
        $response->assertSee('コンビニ払い');

        //「カード支払い」を選択してPOST送信
        $response = $this->post(route('products.purchase.method', $product->id), [
            'payment_method' => 2,
        ]);

        $this->assertEquals(2, session('selected_payment_method'));

        // 再表示で「カード支払い」が選ばれていることを確認
        $response = $this->get(route('products.purchase', $product->id));
        $response->assertSee('カード支払い');
    }

}
