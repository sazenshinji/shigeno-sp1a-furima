@extends('layouts.app')

@section('content')
<div class="product-grid">
  @foreach ($products as $product)
  <div class="product-card">
    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
    <p>{{ $product->name }}</p>
  </div>
  @endforeach
</div>
@endsection