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
      <div class="image-upload-box" onclick="document.getElementById('image').click()">
        <p id="image-placeholder">画像を選択する</p>
        <img id="preview" src="" alt="" style="display:none;">
      </div>
      <input type="file" name="image" id="image" accept="image/*" style="display:none;" required>
    </div>

    {{-- 商品詳細 --}}
    <div class="form-section">
      <h3>商品の詳細</h3>
      <hr>

      <label>商品名</label>
      <input type="text" name="name" required>

      <label>価格</label>
      <input type="number" name="price" required>

      <label>ブランド</label>
      <input type="text" name="brand">

      <label>説明</label>
      <textarea name="description" rows="3" required></textarea>

      {{-- カテゴリー --}}
      <label>カテゴリー</label>
      <div class="category-list">
        @foreach($categories as $category)
        <label class="category-tag">
          <input type="checkbox" name="categories[]" value="{{ $category->id }}">
          <span>{{ $category->name }}</span>
        </label>
        @endforeach
      </div>

      {{-- コンディション --}}
      <label>商品の状態</label>
      <select name="condition_id" required>
        <option value="">選択してください</option>
        @foreach($conditions as $condition)
        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="submit-btn">出品する</button>
  </form>
</div>

<script>
  document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('image-placeholder');

    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        preview.src = event.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
      }
      reader.readAsDataURL(file);
    }
  });
</script>
@endsection