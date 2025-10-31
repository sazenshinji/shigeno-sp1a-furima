@extends('layouts.app_login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-container">

  <p>
    登録していただいたメールアドレスに認証メールを送付しました。<br>
    メール認証を完了してください。
  </p>

  {{-- 新しい「認証はこちらから」ボタン --}}
  <div class="verify-actions">
    <a href="http://localhost:8025/" class="mailhog-button">
      認証はこちらから
    </a>
  </div>

  {{-- 確認メール再送フォーム --}}
  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">認証メールを再送する</button>
  </form>
</div>
@endsection