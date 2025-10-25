<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;

class O_ExhibitionTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_出品商品情報登録()
    {
        // ----------------------------------------------------
        // ① user_id=1でログイン
        // ----------------------------------------------------
        $user = User::find(1);
        $this->actingAs($user);

        // ----------------------------------------------------
        // ② 出品画面を開く
        // ----------------------------------------------------
        $response = $this->get(route('products.create'));
        $response->assertStatus(200);
        $response->assertSee('商品の出品');
        $response->assertSee('カテゴリー');
        $response->assertSee('商品の状態');

        // ----------------------------------------------------
        // ③ 必須カテゴリー・コンディション情報を取得
        // ----------------------------------------------------
        $categoryKitchen = Category::where('name', 'キッチン')->first();
        $categoryHandmade = Category::where('name', 'ハンドメード')->first();
        $condition = Condition::where('name', '良好')->first();

        // ----------------------------------------------------
        // ④ ダミー画像（必須入力を通過させるため）
        // ----------------------------------------------------
        $file = UploadedFile::fake()->create('dummy.jpg', 100);

        // ----------------------------------------------------
        // ⑤ 出品フォームをPOST送信（画像あり・保存確認なし）
        // ----------------------------------------------------
        $postData = [
            'image' => $file,
            'categories' => [$categoryKitchen->id, $categoryHandmade->id],
            'condition_id' => $condition->id,
            'name' => 'パイナップル',
            'brand' => '埼玉農園',
            'description' => '自家栽培',
            'price' => 1000,
        ];

        $response = $this->post(route('products.store'), $postData);

        // ----------------------------------------------------
        // ⑥ 登録後リダイレクト確認
        // ----------------------------------------------------
        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));

        // ----------------------------------------------------
        // ⑦ productsテーブルに登録内容を確認
        // ----------------------------------------------------
        $this->assertDatabaseHas('products', [
            'name' => 'パイナップル',
            'brand' => '埼玉農園',
            'description' => '自家栽培',
            'price' => 1000,
            'seller_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // ----------------------------------------------------
        // ⑧ 登録されたproductのIDを取得
        // ----------------------------------------------------
        $product = Product::where('name', 'パイナップル')->first();
        $this->assertNotNull($product, '商品がproductsテーブルに登録されていること');

        // ----------------------------------------------------
        // ⑨ category_productテーブルに2つのカテゴリが登録されていることを確認
        // ----------------------------------------------------
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $categoryKitchen->id,
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $categoryHandmade->id,
        ]);
    }
}
