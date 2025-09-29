@extends('layouts.app')

@section('content')

<div class="product-detail">
  <div class="product-detail-left">
    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="detail-image">
  </div>

  <div class="product-detail-right">
    <h2>{{ $product->name }}</h2>
    <p class="brand">{{ $product->brand }}</p>
    <p class="price">{{ number_format($product->price) }}円 <span>(税込)</span></p>

    <div class="icons">
      <div class="icon">
        <img src="{{ asset('storage/images/21_star.png') }}" alt="いいね">
        <span>{{ $product->likes->count() }}</span>
      </div>
      <div class="icon">
        <img src="{{ asset('storage/images/22_comment.png') }}" alt="コメント">
        <span>{{ $product->comments->count() }}</span>
      </div>
    </div>

    <button class="purchase-btn">購入手続きへ</button>

    <h3>商品説明</h3>
    <p class="description">{{ $product->description }}</p>
  </div>
</div>

@endsection