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
  <a href="{{ route('profile.show', ['tab' => 'sell', 'keyword' => request('keyword')]) }}"
    class="tab-link {{ $activeTab === 'sell' ? 'active' : '' }}">出品した商品</a>

  <a href="{{ route('profile.show', ['tab' => 'buy', 'keyword' => request('keyword')]) }}"
    class="tab-link {{ $activeTab === 'buy' ? 'active' : '' }}">購入した商品</a>
</div>

<hr class="tab-divider"><!-- 横線 -->

{{-- 出品した商品 --}}
@if ($activeTab === 'sell')
<div class="tab-content active">
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
@endif

{{-- 購入した商品 --}}
@if ($activeTab === 'buy')
<div class="tab-content active">
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
@endif

@endsection