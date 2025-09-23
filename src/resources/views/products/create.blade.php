@extends('layouts.app')

@section('content')
<h2>商品を出品する</h2>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div>
    <label>商品名：</label>
    <input type="text" name="name" required>
  </div>
  <div>
    <label>商品画像：</label>
    <input type="file" name="image" accept="image/*" required>
  </div>
  <button type="submit">出品</button>
</form>
@endsection
