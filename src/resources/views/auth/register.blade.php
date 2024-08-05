@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
@if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif
<div class="form__text">
    <p>会員登録</p>
</div>
<form method="post" action="/register" class="register__form">
    @csrf
    <div class="form__item">
        <input type="text" name="name" class="form__input" value="{{ old('name') }}" placeholder="名前">
    </div>
    <div class="form__item">
        <input type="email" name="email" class="form__input" value="{{ old('email') }}" placeholder="メールアドレス">
    </div>
    <div class="form__item">
        <input type="password" name="password" class="form__input" placeholder="パスワード">
    </div>
    <div class="form__item">
        <input type="password" name="password_confirmation" class="form__input" placeholder="確認用パスワード">
    </div>
    <div class="form__item">
        <button type="submit" class="form__input-button">会員登録</button>
    </div>
</form>
<div class="login__text">
    <p>アカウントをお持ちの方はこちらから</p>
</div>
<div class="login__item">
    <a href="/login" class="login__link">ログイン</a>
</div>
@endsection
