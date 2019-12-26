<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav class="my-navbar">
    <a class="my-navbar-brand" href="/">ToDo App</a>
        <div class="my-navbar-control">
            @if(Auth::check())
                <form action="{{route('tasks.search')}}">
                    <input type="text" name="keyword" >
                    <input type="submit" value="検索" class="btn btn-info">
                </form>
                |
                <span class="my-navbar-item">ようこそ, {{ Auth::user()->name }}さん</span>
                |
                <a href="{{ route('users.index', ['user' => Auth::id() ]) }}" class="my-navbar-item">ユーザーページ</a>
                |
                <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                |
                <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
            @endif
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
@if(Auth::check())
    <script>
        document.getElementById('logout').addEventListener('click', function(event){
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
@endif
@yield('scripts')
</body>
</html>
