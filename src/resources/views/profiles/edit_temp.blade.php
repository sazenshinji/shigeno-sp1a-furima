@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_temp.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
  <h2 class="title">住所の変更</h2>

  <form action="{{ route('profile.update_temp') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ request('product_id') }}">

    <label for="postal_code">郵便番号</label>
    <input type="text" id="postal_code" name="postal_code"
      value="{{ old('postal_code', $tempProfile['postal_code'] ?? '') }}">
    @error('postal_code')
    <div class="error">{{ $message }}</div>
    @enderror

    <label for="address">住所</label>
    <input type="text" id="address" name="address"
      value="{{ old('address', $tempProfile['address'] ?? '') }}">
    @error('address')
    <div class="error">{{ $message }}</div>
    @enderror

    <label for="building">建物名</label>
    <input type="text" id="building" name="building"
      value="{{ old('building', $tempProfile['building'] ?? '') }}">
    @error('building')
    <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="update-btn">更新する</button>
  </form>
</div>
@endsection