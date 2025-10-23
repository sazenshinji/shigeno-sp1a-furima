<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginLogoutTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_ログイン機能_バリデーション_email_required()
    {
        //フォームデータ
        $formData = [
            // 'email' => '1234@abcd',
            'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }
    public function test_ログイン機能_バリデーション_password_required()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd',
            // 'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'email',
            'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }
    public function test_ログイン機能_バリデーション_wronginformation_email()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd',             //間違ったemailアドレス
            'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }
    public function test_ログイン機能_バリデーション_wronginformation_password()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd1',
            'password' => '12345679',       //間違ったPassword
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }
    public function test_ログイン機能ログアウト機能()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd1',
            'password' => '12345678',
        ];
        // POSTリクエスト
        $this->post('/login', $formData);

        //実際に /profile にアクセスできる（authミドルウェアが有効）ことを確認
        $protectedResponse = $this->get('/profile');
        $protectedResponse->assertStatus(200);
        $protectedResponse->assertViewIs('profiles.profile'); // ← 実際のビュー名に合わせる

        // ログアウト
        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/');
        $protectedResponse = $this->get('/profile');
        $protectedResponse->assertStatus(302);

    }
}
