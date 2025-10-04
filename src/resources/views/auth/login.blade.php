@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="auth-container">

  <h2>ログイン</h2>
  <form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div>
      <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
      @error('email')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <input type="password" name="password" placeholder="パスワード">
      @error('password')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit">ログインする</button>
  </form>

  <a href="{{ route('register') }}">会員登録はこちら</a>
</div>

@endsection