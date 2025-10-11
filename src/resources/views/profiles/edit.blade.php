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

    {{-- 画像プレビューと画像選択ボタンを横並び --}}
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
    

    <input type="text" name="username" placeholder="ユーザー名"
      value="{{ old('username', $profile->username ?? '') }}">
    @error('username')
    <div class="error-message">{{ $message }}</div>
    @enderror

    <input type="text" name="postal_code" placeholder="郵便番号"
      value="{{ old('postal_code', $profile->postal_code ?? '') }}">
    @error('postal_code')
    <div class="error-message">{{ $message }}</div>
    @enderror

    <input type="text" name="address" placeholder="住所"
      value="{{ old('address', $profile->address ?? '') }}">
    @error('address')
    <div class="error-message">{{ $message }}</div>
    @enderror

    <input type="text" name="building" placeholder="建物名"
      value="{{ old('building', $profile->building ?? '') }}">
    @error('building')
    <div class="error-message">{{ $message }}</div>
    @enderror

    <button type="submit">更新する</button>
  </form>

</div>

<!-- Loading script for image confirmation -->
<script src="{{ asset('js/update_img_script.js') }}"></script>

@endsection