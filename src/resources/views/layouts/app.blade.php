<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>フリマアプリ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>
  <meta name="stripe-key" content="{{ config('services.stripe.key') }}">
  @yield('css')
</head>

<body>
  <header class="header">

    <div class="logo">
      <a href="{{ url('/') }}">
        <img class="logo-img" src="{{ asset('images/Coachtech.jpg') }}" alt="フリマ">
      </a>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="search-box">
      <input type="text" name="keyword" placeholder="  なにをお探しですか？"
        value="{{ request('keyword') }}">
    </form>

    <div class="nav-buttons">
      @if(Auth::check())
      {{-- ログイン済みならログアウトリンク --}}
      <a href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="nav-logout">ログアウト</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      @else
      {{-- 未ログインならログインリンク --}}
      <a href="{{ route('login') }}" class="nav-login">ログイン</a>
      @endif

      <a href="{{ route('profile.show') }}" class="nav-mypage">マイページ</a>
      <a href="{{ route('products.create') }}" class="nav-create">出品</a>
    </div>

  </header>

  <main class="content">
    @yield('content')
  </main>
</body>

</html>