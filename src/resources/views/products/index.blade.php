@extends('layouts.app')

@section('content')

{{-- タブ切り替え --}}
<div class="tabs">
  <a href="{{ route('products.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
    class="tab {{ $tab === 'recommend' ? 'active' : '' }}">
    おすすめ
  </a>

  @if(Auth::check())
  <a href="{{ route('products.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
    class="tab {{ $tab === 'mylist' ? 'active' : '' }}">
    マイリスト
  </a>
  @else
  <span class="tab disabled">マイリスト</span>
  @endif
</div>

@if(!empty($keyword))
<p class="search-result">「{{ $keyword }}」の検索結果</p>
@endif

<div class="product-grid">
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
</div>

@endsection