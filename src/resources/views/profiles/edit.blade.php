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

    {{-- 画像プレビュー --}}
    <div class="profile-image-wrapper">
      <img id="preview-image"
        src="{{ $profile && $profile->user_image ? asset('storage/' . $profile->user_image) : '' }}"
        alt="ユーザー画像"
        class="profile-image"
        style="max-width:150px; display: {{ $profile && $profile->user_image ? 'block' : 'none' }};">
    </div>

    {{-- 画像選択 --}}
    <input type="file" name="user_image" id="user_image" accept="image/*">

    <input type="text" name="username" placeholder="ユーザー名"
      value="{{ old('username', $profile->username ?? '') }}">
    <input type="text" name="postal_code" placeholder="郵便番号"
      value="{{ old('postal_code', $profile->postal_code ?? '') }}">
    <input type="text" name="address" placeholder="住所"
      value="{{ old('address', $profile->address ?? '') }}">
    <input type="text" name="building" placeholder="建物名"
      value="{{ old('building', $profile->building ?? '') }}">
    <button type="submit">更新する</button>
  </form>

</div>

<!-- Loading script for image confirmation -->
<script src="{{ asset('js/update_img_script.js') }}"></script>

@endsection