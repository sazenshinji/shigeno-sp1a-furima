@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

{{-- タブ切り替え --}}
<div class="tabs">
  <a href="{{ route('products.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
    class="tab {{ $tab === 'recommend' ? 'active' : '' }}">
    おすすめ
  </a>

  {{-- ログインしていなくてもリンクを有効化 --}}
  <a href="{{ route('products.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
    class="tab {{ $tab === 'mylist' ? 'active' : '' }}">
    マイリスト
  </a>
</div>

@if(!empty($keyword))
<p class="search-result">「{{ $keyword }}」の検索結果</p>
@endif

<div class="product-grid">
  {{-- 「マイリスト」タブを開いた時の分岐 --}}
  @if ($tab === 'mylist' && !Auth::check())
  <p class="login-required-message">マイリストの表示にはログインが必要です。</p>
  @else
  @forelse ($products as $product)
  <div class="product-card">
    <a href="{{ route('products.show', $product->id) }}">
      <div class="product-image-wrapper">
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
        @if ($product->is_sold)
        <img src="{{ asset('storage/images/11_sold2.png') }}" alt="SOLD" class="sold-overlay">
        @endif
      </div>
      <p>{{ $product->name }}</p>
    </a>
  </div>
  @empty
  <p>該当する商品は見つかりませんでした。</p>
  @endforelse
  @endif
</div>

@endsection