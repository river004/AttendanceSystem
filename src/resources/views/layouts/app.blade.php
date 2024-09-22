<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-logo">
                <div class="header-logo__text">
                    <a href="/">Atte</a>
                </div>
            </div>
            <div class="header-nav">
                <ul class="header-nav__list">
                    @if (Auth::check())
                    <li class="header-nav__item">
                        <a href="/" class="header-nav__link">ホーム</a>
                    </li>
                    <li class="header-nav__item">
                        <a href="{{ route('attendance/date', ['date' => now()->format('Y-m-d')]) }}" class="btn btn-primary" class="header-nav__link">日付一覧</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__link" href="{{ route('user') }}">ユーザー一覧</a>
                    </li>
                    <li class="header-nav__item">
                        <form action="logout" method="post">
                            @csrf
                            <button class="logout-button" type="submit">ログアウト</button>
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="footer__item">
            <small class="footer__text">
                Atte,inc.
            </small>
        </div>
    </footer>
</body>
</html>