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

        <form action="{{ route('products.purchase.method', $product->id) }}" method="POST" id="method-form">
            @csrf
            <select name="payment_method" id="payment-select" class="payment-select">
                <option value="">選択してください</option>
                <option value="1" {{ $selectedMethod == 1 ? 'selected' : '' }}>コンビニ払い</option>
                <option value="2" {{ $selectedMethod == 2 ? 'selected' : '' }}>カード支払い</option>
            </select>
        </form>

        <hr>

        {{-- 配送先 --}}
        <div class="address-header">
            <h4>配送先</h4>
            <a href="{{ route('profile.edit_temp', ['product_id' => $product->id]) }}" class="address-edit">変更する</a>
        </div>

        @php
        $rawProfile = session('temp_profile') ?? $profile;
        if (is_array($rawProfile)) {
        $displayProfile = $rawProfile;
        } elseif ($rawProfile) {
        $displayProfile = $rawProfile->only(['postal_code', 'address', 'building']);
        } else {
        $displayProfile = null;
        }
        @endphp

        <div class="address-display">
            @if ($displayProfile)
            <p>〒 {{ $displayProfile['postal_code'] ?? '' }}</p>
            <p>{{ $displayProfile['address'] ?? '' }}</p>
            <p>{{ $displayProfile['building'] ?? '' }}</p>
            @else
            <p class="error-noaddress">住所の登録がありません。</p>
            @endif
        </div>

    </div>

    <div class="purchase-right">
        <div class="summary-box">
            <h4>商品代金</h4>
            <p>￥{{ number_format($product->price) }}</p>
        </div>

        <div class="summary-box">
            <h4>支払い方法</h4>
            <p id="selected-method">
                @if($selectedMethod == 1)
                コンビニ払い
                @elseif($selectedMethod == 2)
                カード支払い
                @else
                選択してください
                @endif
            </p>
        </div>

        {{-- 購入ボタン（最終決済） --}}
        <form id="payment-form" action="{{ route('products.checkout', $product->id) }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method" value="{{ $selectedMethod }}">
            <input type="hidden" name="postal_code" value="{{ $displayProfile['postal_code'] ?? '' }}">
            <input type="hidden" name="address" value="{{ $displayProfile['address'] ?? '' }}">
            <input type="hidden" name="building" value="{{ $displayProfile['building'] ?? '' }}">
            <button type="submit" class="purchase-btn">購入する</button>
        </form>

        {{-- エラー --}}
        @error('payment_method')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Stripe公開鍵をBladeからJSに渡す --}}
<script>
    window.stripePublicKey = "{{ env('STRIPE_KEY') }}";
</script>

{{-- Stripe初期化用スクリプト --}}
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/purchase_script.js') }}"></script>

@endsection