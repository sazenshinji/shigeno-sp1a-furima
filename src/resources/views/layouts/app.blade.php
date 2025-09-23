<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>フリマアプリ</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
  <header class="header">
    <div class="logo">フリマ</div>
    <form action="{{ route('products.index') }}" method="GET" class="search-box">
      <input type="text" name="keyword" placeholder="商品を検索">
      <button type="submit">検索</button>
    </form>
    <div class="nav-buttons">
      <a href="#">ログイン</a>
      <a href="#">マイページ</a>
      <a href="{{ route('products.create') }}">出品</a>
    </div>
  </header>

  <main class="content">
    @yield('content')
  </main>
</body>

</html>