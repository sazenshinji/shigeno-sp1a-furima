@extends('layouts.app')

@section('content')

<div class="product-detail">
  <div class="product-detail-left">
    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="detail-image">
  </div>

  <div class="product-detail-right">
    <h2>{{ $product->name }}</h2>
    <p class="brand">{{ $product->brand }}</p>
    <p class="price">￥{{ number_format($product->price) }} <span>(税込)</span></p>

    <div class="icons">
      <div class="icon-row">
        @auth
        <button class="like-btn" data-product-id="{{ $product->id }}">
          <img src="{{ asset($product->isLikedBy(Auth::user()) 
            ? 'storage/images/21_star_red.png' 
            : 'storage/images/21_star.png') }}"
            alt="いいね" class="like-icon">
        </button>
        @else
        <img src="{{ asset('storage/images/21_star.png') }}" alt="いいね">
        @endauth

        <img src="{{ asset('storage/images/22_comment.png') }}" alt="コメント">
      </div>

      <div class="count-row">
        <span id="like-count">{{ $product->likes->count() }}</span>
        <span>{{ $product->comments->count() }}</span>
      </div>
    </div>

    <button class="purchase-btn">購入手続きへ</button>

    <h3>商品説明</h3>
    <p class="description">{{ $product->description }}</p>

    <h3>商品の情報</h3>
    <div class="product-info">
      <p><strong>カテゴリー：</strong>
        @foreach($product->categories as $category)
        <span class="badge">{{ $category->name }}</span>
        @endforeach
      </p>

      <p><strong>商品の状態：</strong>
        {{ $product->condition->name }}
      </p>
    </div>

  </div>
</div>

<script src="{{ asset('js/likes_script.js') }}"></script>

@endsection