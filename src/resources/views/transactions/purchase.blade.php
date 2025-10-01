@extends('layouts.app')

@section('content')
<div class="purchase-container">
    <div class="purchase-left">
        {{-- 商品情報 --}}
        <div class="product-info-box">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="purchase-product-img">
            <div>
                <h3>{{ $product->name }}</h3>
                <p class="price">￥{{ number_format($product->price) }}</p>
            </div>
        </div>

        <hr>

        {{-- 支払い方法 --}}
        <h4>支払い方法</h4>
        <form action="{{ route('products.purchase.store', $product->id) }}" method="POST">
            @csrf
            <select name="payment_method" class="payment-select" required>
                <option value="">選択してください</option>
                <option value="1">コンビニ払い</option>
                <option value="2">カード支払い</option>
            </select>
            @error('payment_method')
            <div class="error">{{ $message }}</div>
            @enderror

            <hr>

            {{-- 配送先 --}}
            <div class="address-header">
                <h4>配送先</h4>
                <a href="{{ route('profile.edit') }}" class="address-edit">変更する</a>
            </div>
            <p>〒 {{ $profile->postal_code }}</p>
            <p>{{ $profile->address }}</p>
            <p>{{ $profile->building }}</p>
    </div>

    <div class="purchase-right">
        <div class="summary-box">
            <h4>商品代金</h4>
            <p>￥{{ number_format($product->price) }}</p>
        </div>
        <div class="summary-box">
            <h4>支払い方法</h4>
            <p id="selected-method">選択してください</p>
        </div>
        <button type="submit" class="purchase-btn">購入する</button>
        </form>
    </div>
</div>
@endsection
