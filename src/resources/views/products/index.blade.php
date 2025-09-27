@extends('layouts.app')

@section('content')

@if(!empty($keyword))
<p class="search-result">「{{ $keyword }}」の検索結果</p>
@endif

<div class="product-grid">
  @forelse ($products as $product)
  <div class="product-card">
    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
    <p>{{ $product->name }}</p>
  </div>
  @empty
  <p>該当する商品は見つかりませんでした。</p>
  @endforelse
</div>

@endsection