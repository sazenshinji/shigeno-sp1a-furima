@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-header">
  <img src="{{ asset('storage/' . ($profile->user_image ?? 'images/default-user.png')) }}" alt="ユーザー画像">
  <div class="profile-info">
    <p class="profile-name">{{ $profile->username ?? Auth::user()->name }}</p>
    <a href="{{ route('profile.edit') }}" class="profile-edit-btn">プロフィールを編集</a>
  </div>
</div>

{{-- タブ切り替え --}}
<div class="tabs">
  <button class="tab-link active" data-tab="sell">出品した商品</button>
  <button class="tab-link" data-tab="buy">購入した商品</button>
</div>

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
    <p>出品した商品はありません。</p>
    @endforelse
  </div>
</div>

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
    <p>購入した商品はありません。</p>
    @endforelse
  </div>
</div>
</div>

<script>
  // タブ切り替えスクリプト
  document.querySelectorAll('.tab-link').forEach(button => {
    button.addEventListener('click', () => {
      document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

      button.classList.add('active');
      document.getElementById(button.dataset.tab).classList.add('active');
    });
  });
</script>
@endsection