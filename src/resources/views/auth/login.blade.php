@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
    <p>ログイン</p>
</div>
<form method="post" action="/login" class="login__form">
    @csrf
    <div class="form__item">
        <input type="email" name="email" class="form__input" value="{{ old('email') }}" placeholder="メールアドレス">
    </div>
    <div class="form__item">
        <input type="password" name="password" class="form__input" placeholder="パスワード">
    </div>
    <div class="form__item">
        <button type="submit" class="form__input-button">ログイン</button>
    </div>
</form>
<div class="register__text">
    <p>アカウントをお持ちでない方はこちらから</p>
</div>
<div class="register__item">
    <a href="/register" class="register__link">会員登録</a>
</div>
@endsection
