@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="auth-container">
  <h2>会員登録</h2>
  <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf

    <input type="text" name="name" placeholder="ユーザー名" value="{{ old('name') }}">
    @error('name')
    <div class="error">{{ $message }}</div>
    @enderror

    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
    @error('email')
    <div class="error">{{ $message }}</div>
    @enderror

    <input type="password" name="password" placeholder="パスワード">
    @error('password')
    <div class="error">{{ $message }}</div>
    @enderror

    <input type="password" name="password_confirmation" placeholder="確認用パスワード">
    @error('password_confirmation')
    <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">登録する</button>
  </form>

  <a href="{{ route('login') }}">ログインはこちら</a>
</div>
@endsection