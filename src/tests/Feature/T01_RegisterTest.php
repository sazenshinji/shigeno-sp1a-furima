<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T01_RegisterTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_会員登録機能_バリデーション_name_required()
    {
        //フォームデータ
        $formData = [
            // 'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'name',
            // 'email',
            // 'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('お名前を入力してください', $errors['name'][0]);
    }

    public function test_会員登録機能_バリデーション_email_required()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            // 'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            'email',
            // 'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }

    public function test_会員登録機能_バリデーション_password_required()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            // 'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }

    public function test_会員登録機能_バリデーション_password_min()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('パスワードは8文字以上で入力してください', $errors['password'][0]);
    }

    public function test_会員登録機能_バリデーション_password_confirmed()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345679',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('パスワードと一致しません', $errors['password'][0]);
    }

    public function test_会員登録機能_登録成功後の遷移()
    {
        // 正しい入力データ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        // POSTリクエスト実行
        $response = $this->post('/register', $formData);

        // ① 登録後のリダイレクト先を確認
        $response->assertRedirect('/email/verify');

        // ② usersテーブルに新しいユーザーが保存されたことを確認
        //    name と email が正しく入っていること
        $this->assertDatabaseHas('users', [
            'name'  => '山田 太郎',
            'email' => '1234@abcd',
        ]);

        // ③ レコード件数が 6 件になっていることを確認
        //    （Seederで5件＋今登録した1件）
        $this->assertDatabaseCount('users', 6);

        // ④ /email/verify が正常に表示できることを確認
        $this->get('/email/verify')
            ->assertStatus(200)
            ->assertViewIs('auth.verify-email');
    }
}
