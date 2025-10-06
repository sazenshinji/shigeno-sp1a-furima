@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/konbini.css') }}">
@endsection

@section('content')
<div class="konbini-container">
    <h2>コンビニ支払い情報</h2>
    <p>以下の情報でコンビニからお支払いください。</p>

    <div class="konbini-box">
        <ul>
            <li>金額: ￥{{ number_format($product->price) }}</li>
            <li>支払い期限: {{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d H:i') }}</li>
            <li>支払い番号などはテスト時 Stripe ダッシュボードから確認可能</li>
        </ul>
    </div>

    <p class="note">※テストモードでは実際にコンビニでの支払いはできません。</p>

    <a href="{{ route('products.index') }}" class="purchase-btn">商品一覧に戻る</a>
</div>
@endsection