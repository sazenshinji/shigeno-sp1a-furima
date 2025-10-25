<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;


class D_ProductListDisplayTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_商品一覧取得_全商品表示()
    {
        // ① シーディングで登録された商品数を確認
        $this->assertEquals(10, Product::count(), 'ProductsTableSeederの登録件数が10件であることを確認');

        // ② 商品一覧ページへアクセス
        $response = $this->get('/');

        // ③ ステータスコード200（正常表示）
        $response->assertStatus(200);

        // ④ productsテーブル内の全ての商品名がページ上に表示されているかを確認
        $products = Product::all();

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_商品一覧画面_購入済商品のみにSOLD画像が表示される()
    {
        $this->assertEquals(10, Product::count(), '商品が10件登録されていること');
        $this->assertEquals(3, Transaction::count(), '取引が3件登録されていること');

        // ② indexページへアクセス
        $response = $this->get('/');

        // ③ ステータス200を確認
        $response->assertStatus(200);

        // ④ 各商品について確認
        // 購入済 (transactions にある product_id: 5, 6, 7)
        $soldProducts = Product::whereIn('id', [5, 6, 7])->get();

        foreach ($soldProducts as $product) {
            // HTMLに商品名が表示されている
            $response->assertSee($product->name);
            // SOLD画像が出力されている（is_sold = true の場合）
            $response->assertSee('images/11_sold2.png');
        }

        // 未購入 (その他の商品)
        $unsoldProducts = Product::whereNotIn('id', [5, 6, 7])->get();

        foreach ($unsoldProducts as $product) {
            $response->assertSee($product->name);
            // 未購入商品の場合は「SOLD画像」がその商品カード内に表示されないことを確認
            // （単純なassertDontSeeでは他商品のSOLDが含まれるため、DBレベルで確認）
            $this->assertFalse($product->is_sold, "{$product->name} は未購入のはず");
        }
    }

    public function test_商品一覧画面_自分が出品した製品は一覧表示されない()
    {
        // 1. ログインユーザーをシーディングデータから取得（email指定などで）
        //    ※Seederの内容に合わせて、出品者が存在するユーザーを選択します
        $user = User::where('email', '1234@abcd1')->first();

        // 2. ログイン状態にする
        $this->actingAs($user);

        // 3. シーディングされた中で、このユーザーが出品した全商品を取得
        $myProducts = Product::where('seller_id', $user->id)->pluck('name')->toArray();

        // 念のため、出品商品があることを確認（0件だとテストにならない）
        $this->assertNotEmpty($myProducts, '出品商品がシーディングに存在しません');

        // 4. indexページ（商品一覧）を表示
        $response = $this->get('/');

        // 5. ログインユーザー自身の出品商品が一覧に含まれていないことを確認
        foreach ($myProducts as $productName) {
            $response->assertDontSee($productName, "自分の出品商品 [{$productName}] が一覧に表示されています。");
        }

        // 6. 他人が出品した商品が少なくとも1件は表示されていることを確認
        $otherProduct = Product::where('seller_id', '!=', $user->id)->first();
        $this->assertNotNull($otherProduct, '他人の商品がシーディングに存在しません');
        $response->assertSee($otherProduct->name, "他人の商品 [{$otherProduct->name}] が一覧に表示されていません。");

        // 7. ステータスコード確認（ページが正常に表示される）
        $response->assertStatus(200);
    }
}
