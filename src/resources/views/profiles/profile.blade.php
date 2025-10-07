@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-header">
  {{-- プロフ画像 --}}
  <img src="{{ asset('storage/' . ($user->profile->user_image ?? 'images/23_default-user.png')) }}"
    alt="ユーザー画像"
    class="profile-image">

  {{-- ユーザー名 --}}
  <p class="profile-name">{{ $user->name }}</p>

  {{-- プロフィール編集ボタン --}}
  <a href="{{ route('profile.edit', ['from' => 'profile']) }}" class="profile-edit-btn">プロフィールを編集</a>
</div>

{{-- タブ切り替え --}}
<div class="tabs">
  <button class="tab-link active" data-tab="sell">出品した商品</button>
  <button class="tab-link" data-tab="buy">購入した商品</button>
</div>

<hr class="tab-divider"><!-- 横線追加 -->

{{-- 出品した商品 --}}
<div id="sell" class="tab-content active">
  <div class="product-grid">
    @forelse ($myProducts as $product)
    <div class="product-card">
      <a href="{{ route('products.show', $product->id) }}">
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
        <p>{{ $product->name }}</p>
      </a>
    </div>
    @empty
    <p class="empty-message">出品した商品はありません。</p>
    @endforelse
  </div>
</div>

{{-- 購入した商品 --}}
<div id="buy" class="tab-content">
  <div class="product-grid">
    @forelse ($purchasedProducts as $product)
    <div class="product-card">
      <a href="{{ route('products.show', $product->id) }}">
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
        <p>{{ $product->name }}</p>
      </a>
    </div>
    @empty
    <p class="empty-message">購入した商品はありません。</p>
    @endforelse
  </div>
</div>

<script>
  // タブ切り替えスクリプト
  document.querySelectorAll('.tab-link').forEach(button => {
    button.addEventListener('click', () => {
      // 全てのタブからactiveを外す
      document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

      // クリックされたタブをactiveにする
      button.classList.add('active');
      document.getElementById(button.dataset.tab).classList.add('active');
    });
  });
</script>
@endsection