<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profile;

class N_UserInformationChangeTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_ユーザー情報変更()
    {
        // ----------------------------------------------------
        // ① user_id=1 でログイン
        // ----------------------------------------------------
        $user = User::find(1);
        $this->actingAs($user);

        // ----------------------------------------------------
        // ② index画面で[マイページ]ボタンを押し /profile に遷移
        // ----------------------------------------------------
        $indexResponse = $this->get(route('products.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('マイページ');

        $profileResponse = $this->get(route('profile.show'));
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('プロフィールを編集');

        // ----------------------------------------------------
        // ③ [プロフィールを編集] ボタン押下で /profile/edit?from=profile に遷移
        // ----------------------------------------------------
        $editUrl = route('profile.edit', ['from' => 'profile']);
        $editResponse = $this->get($editUrl);
        $editResponse->assertStatus(200);

        // ----------------------------------------------------
        // ④ profilesテーブルに登録されたデータを確認
        // ----------------------------------------------------
        $profile = Profile::where('user_id', $user->id)->first();
        $this->assertNotNull($profile, 'profilesテーブルにデータが存在すること');

        // ----------------------------------------------------
        // ⑤ 画面上にprofilesテーブルの内容が表示されていることを確認
        // ----------------------------------------------------
        $editResponse->assertSee('プロフィール設定');
        $editResponse->assertSee($profile->username);
        $editResponse->assertSee($profile->postal_code);
        $editResponse->assertSee($profile->address);
        $editResponse->assertSee($profile->building);
        $editResponse->assertSee($profile->user_image);

        // ----------------------------------------------------
        // ⑥ フォーム構造（inputやbuttonなど）も確認
        // ----------------------------------------------------
        $editResponse->assertSee('<input', false); // HTMLタグ確認
        $editResponse->assertSee('type="file"', false);
        $editResponse->assertSee('type="text"', false);
        $editResponse->assertSee('更新する');
    }
}
