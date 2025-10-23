<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ProductSearchTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_商品検索機能_部分一致検索()
    {
        // 検索キーワード「ー」でリクエストを送信
        $response = $this->get(route('products.index', ['keyword' => 'ー']));

        // ステータス 200（正常表示）
        $response->assertStatus(200);

        // 表示されるべき商品（キーワード「ー」を含む）
        $shouldBeVisible = [
            'ノートPC',
            'ショルダーバッグ',
            'タンブラー',
            'コーヒーミル',
        ];

        // 表示されるべき商品名がすべて含まれているか確認
        foreach ($shouldBeVisible as $productName) {
            $response->assertSee($productName);
        }

        // 表示されないべき商品
        $shouldNotBeVisible = [
            '腕時計',
            'HDD',
            '玉ねぎ3束',
            '革靴',
            'マイク',
            'メイクセット',
        ];

        foreach ($shouldNotBeVisible as $productName) {
            $response->assertDontSee($productName);
        }
    }
    public function test_商品検索機能_部分一致検索とマイリスト表示()
    {
        // user_id=2 のユーザーでログイン
        $user = \App\Models\User::find(2);
        $this->actingAs($user);

        // 検索キーワード「ー」でリクエスト（マイリストタブ）
        $response = $this->get(route('products.index', [
            'tab' => 'mylist',
            'keyword' => 'ー',
        ]));

        // ステータス200（正常表示）
        $response->assertStatus(200);

        // 表示されるべき商品（キーワード「ー」を含む かつ いいね済）
        $response->assertSee('ノートPC');

        // 表示されない商品
        $shouldNotBeVisible = [
            '腕時計',     // いいね済だが「ー」を含まない
            'ショルダーバッグ',
            'タンブラー',
            'コーヒーミル',
            'マイク',
            '玉ねぎ3束',
            '革靴',
            'メイクセット',
            'HDD',
        ];

        foreach ($shouldNotBeVisible as $productName) {
            $response->assertDontSee($productName);
        }
    }
}
