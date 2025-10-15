@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="auth-container">
  <h2>プロフィール設定</h2>

  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="from" value="{{ $from }}">

    {{-- 画像プレビューと画像選択ボタンを横並び（左揃え） --}}
    <div class="profile-image-container">
      <div class="profile-image-wrapper">
        {{-- 画像が未設定のときはグレーの丸を表示 --}}
        <div class="placeholder-circle"
          style="display: {{ $profile && $profile->user_image ? 'none' : 'block' }};"></div>

        <img id="preview-image"
          src="{{ $profile && $profile->user_image ? asset('storage/' . $profile->user_image) : '' }}"
          alt="ユーザー画像"
          class="profile-image"
          style="display: {{ $profile && $profile->user_image ? 'block' : 'none' }};">
      </div>

      {{-- カスタムボタンでファイル選択 --}}
      <label for="user_image" class="custom-file-label">画像を選択する</label>
      <input type="file" name="user_image" id="user_image" accept="image/*">
    </div>

    @error('user_image')
    <div class="error-message">{{ $message }}</div>
    @enderror


    {{-- ユーザー名 --}}
    <div class="form-group">
      <label for="username">ユーザー名</label>
      <input id="username" type="text" name="username"
        value="{{ old('username', $profile->username ?? '') }}">
      @error('username')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    {{-- 郵便番号 --}}
    <div class="form-group">
      <label for="postal_code">郵便番号</label>
      <input id="postal_code" type="text" name="postal_code"
        value="{{ old('postal_code', $profile->postal_code ?? '') }}">
      @error('postal_code')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    {{-- 住所 --}}
    <div class="form-group">
      <label for="address">住所</label>
      <input id="address" type="text" name="address"
        value="{{ old('address', $profile->address ?? '') }}">
      @error('address')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    {{-- 建物名 --}}
    <div class="form-group building-group">
      <label for="building">建物名</label>
      <input id="building" type="text" name="building"
        value="{{ old('building', $profile->building ?? '') }}">
      @error('building')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    {{-- 更新ボタン --}}
    <button type="submit">更新する</button>
  </form>
</div>

<script src="{{ asset('js/update_img_script.js') }}"></script>

@endsection