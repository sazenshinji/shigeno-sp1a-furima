@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

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
        <form action="{{ route('products.purchase.store', $product->id) }}" method="POST" novalidate>
            @csrf
            <select name="payment_method" class="payment-select" required>
                <option value="">選択してください</option>
                <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>コンビニ払い</option>
                <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>カード支払い</option>
            </select>


            <hr>

            {{-- 配送先 --}}
            <div class="address-header">
                <h4>配送先</h4>
                <a href="{{ route('profile.edit_temp', ['product_id' => $product->id]) }}" class="address-edit">変更する</a>
            </div>

            @php
            $displayProfile = session('temp_profile', $profile);
            @endphp

            @if ($displayProfile)
            <p>〒 {{ $displayProfile['postal_code'] ?? $displayProfile->postal_code }}</p>
            <p>{{ $displayProfile['address'] ?? $displayProfile->address }}</p>
            <p>{{ $displayProfile['building'] ?? $displayProfile->building }}</p>
            @else
            <p class="error-noaddress">住所の登録がありません。</p>
            @endif


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

        {{-- ★ エラーメッセージをここにまとめて出す --}}
        @error('payment_method')
        <div class="error">{{ $message }}</div>
        @enderror
        @error('address')
        <div class="error">{{ $message }}</div>
        @enderror

        </form>
    </div>
</div>

<script src="{{ asset('js/purchase_script.js') }}"></script>

@endsection