<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class T16_EmailVerificationTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_メール認証機能()
    {

        // --- 通知をモック（実際にメール送信しない） ---
        Notification::fake();

        // --- register.blade.php のフォーム送信 ---
        $formData = [
            'name' => '山田 太郎',
            'email' => 'testuser@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        $response = $this->post('/register', $formData);

        // 登録後にメール認証案内ページへリダイレクト
        $response->assertRedirect('/email/verify');

        // --- DB確認 ---
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
        $user = User::where('email', 'testuser@example.com')->first();

        // --- メール送信（VerifyEmail通知）を確認 ---
        Notification::assertSentTo($user, VerifyEmail::class);

        // --- verify-email.blade.php の表示確認 ---
        $verifyPage = $this->actingAs($user)->get('/email/verify');
        $verifyPage->assertStatus(200);
        $verifyPage->assertSee('認証はこちらから');
        $verifyPage->assertSee('http://localhost:8025/'); // MailHogリンク

        // --- 認証URL（署名付き）を生成 ---
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        // --- 認証リンクをクリックした場合の動作確認 ---
        $verifyResponse = $this->actingAs($user)->get($verificationUrl);

        // 認証成功後、プロフィール編集画面へリダイレクト
        $verifyResponse->assertRedirect(route('profile.edit'));

        // --- ⑧ edit.blade.php の表示確認 ---
        $editPage = $this->actingAs($user)->get(route('profile.edit'));
        $editPage->assertStatus(200);
        $editPage->assertSee('プロフィール設定');
    }
}
