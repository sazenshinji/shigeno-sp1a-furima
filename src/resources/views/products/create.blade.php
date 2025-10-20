@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

<div class="create-container">
  <h2>商品の出品</h2>

  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- 商品画像エリア --}}
    <div class="form-section">
      <h3>商品画像</h3>
      <div id="image-box" class="image-upload-box" onclick="document.getElementById('image').click()">
        <p id="image-placeholder">画像を選択する</p>
        <img id="preview" src="" alt="" style="display:none;">
      </div>
      <input type="file" name="image" id="image" accept="image/*" style="display:none;">
      @error('image')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    {{-- 商品の詳細 --}}
    <div class="form-section">
      <h3>商品の詳細</h3>
      <hr>

      {{-- カテゴリー --}}
      <label>カテゴリー</label>
      <div class="category-list">
        @foreach($categories as $category)
        <label class="category-tag">
          <input type="checkbox" name="categories[]" value="{{ $category->id }}"
            {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
          <span>{{ $category->name }}</span>
        </label>
        @endforeach
        @error('categories')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      {{-- コンディション --}}
      <div class="condition-section">
        <label>商品の状態</label>
        <select name="condition_id" class="condition-select">
          <option value="">選択してください</option>
          @foreach($conditions as $condition)
          <option value="{{ $condition->id }}"
            {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
            {{ $condition->name }}
          </option>
          @endforeach
        </select>
        @error('condition_id')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      {{-- 商品名・説明エリア --}}
      <div class="form-section">
        <h3>商品名と説明</h3>
        <hr>

        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <label>ブランド名</label>
        <input type="text" name="brand" value="{{ old('brand') }}">

        <label>商品の説明</label>
        <textarea name="description" rows="3">{{ old('description') }}</textarea>
        @error('description')
        <div class="error-message">{{ $message }}</div>
        @enderror

        {{-- 販売価格 --}}
        <label>販売価格</label>
        <div class="price-input-wrapper">
          <span class="yen-symbol">￥</span>
          <input type="number" name="price" value="{{ old('price') }}">
        </div>
        @error('price')
        <div class="error-message">{{ $message }}</div>
        @enderror

      </div>

      <button type="submit" class="submit-btn">出品する</button>
  </form>
</div>

<script src="{{ asset('js/create_script.js') }}"></script>

@endsection