@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="product-detail">
  <div class="product-detail-left">
    <div class="detail-images">
      <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="detail-image">
      @if ($product->is_sold)
      <img src="{{ asset('storage/images/11_sold2.png') }}" alt="SOLD" class="product-sold-overlay">
      @endif
    </div>
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

    @if ($product->is_sold)
    <button class="purchase-btn disabled" disabled>購入済み</button>
    @else
    <a href="{{ route('products.purchase', $product->id) }}" class="purchase-btn">購入手続きへ</a>
    @endif

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

    <h3>コメント({{ $product->comments->count() }})</h3>
    <div class="comments">
      @forelse($product->comments as $comment)
      <div class="comment-item">
        <div class="comment-header">
          @if($comment->user->profile && $comment->user->profile->user_image)
          <img src="{{ asset('storage/' . $comment->user->profile->user_image) }}" class="comment-user-img">
          @else
          <img src="{{ asset('storage/images/default_user.png') }}" class="comment-user-img">
          @endif
          <span class="comment-username">{{ $comment->user->name }}</span>
        </div>
        <div class="comment-body">{{ $comment->comment }}</div>
      </div>
      @empty
      <p>コメントはまだありません。</p>
      @endforelse
    </div>

    @auth
    <h3>商品へのコメント</h3>
    <form action="{{ route('products.comments.store', $product->id) }}" method="POST">
      @csrf
      <textarea name="comment" rows="3" class="comment-textarea" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
      @error('comment')
      <div class="error">{{ $message }}</div>
      @enderror
      <button type="submit" class="comment-submit-btn">コメントを送信する</button>
    </form>
    @endauth

  </div>
</div>

<script src="{{ asset('js/likes_script.js') }}"></script>

@endsection