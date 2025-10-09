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
      <input type="file" name="image" id="image" accept="image/*" style="display:none;" required>
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
          <input type="checkbox" name="categories[]" value="{{ $category->id }}">
          <span>{{ $category->name }}</span>
        </label>
        @endforeach
      </div>

      {{-- コンディション --}}
      <div class="condition-section">
        <label>商品の状態</label>
        <select name="condition_id" required class="condition-select">
          <option value="">選択してください</option>
          @foreach($conditions as $condition)
          <option value="{{ $condition->id }}">{{ $condition->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- 商品名・説明エリア --}}
      <div class="form-section">
        <h3>商品名と説明</h3>
        <hr>

        <label>商品名</label>
        <input type="text" name="name" required>

        <label>ブランド名</label>
        <input type="text" name="brand">

        <label>商品の説明</label>
        <textarea name="description" rows="3" required></textarea>

        {{-- 販売価格 --}}
        <label>販売価格</label>
        <div class="price-input-wrapper">
          <span class="yen-symbol">￥</span>
          <input type="number" name="price" required>
        </div>

      </div>

      <button type="submit" class="submit-btn">出品する</button>
  </form>
</div>

<script>
  document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('image-placeholder');
    const imageBox = document.querySelector('.image-upload-box'); // ← 追加：枠の要素を取得

    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        // 画像を表示
        preview.src = event.target.result;
        preview.style.display = 'block';
        // 「画像を選択する」テキストを非表示
        placeholder.style.display = 'none';
        // ✅ 画像アップロード後に枠を非表示
        imageBox.classList.add('no-border');
      };
      reader.readAsDataURL(file);
    } else {
      // ファイル未選択の場合（再選択なし）
      preview.src = '';
      preview.style.display = 'none';
      placeholder.style.display = 'block';
      // ✅ 枠を再表示
      imageBox.classList.remove('no-border');
    }
  });
</script>

@endsection