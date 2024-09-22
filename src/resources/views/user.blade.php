@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="header__wrap">
        <div class="header__text">
            <h3>ユーザーリスト</h3>
        </div>
        <form method="GET" class="search__item" action="{{ route('user') }}">
            <input class="search__input" type="text" name="search" placeholder="ユーザーIDまたは名前で検索" value="{{ request('search') }}">
            <button class="search__button" type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">ID</th>
                <th class="table__header">名前</th>
                <th class="table__header">勤怠表</th>
            </tr>
            @php
                $pageNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
            @endphp
            @foreach ($users as $user)
                <tr>
                <td class="table__item">{{ $user->id }}</td>
                <td class="table__item">{{ $user->name }}</td>
                <td class="table__item"><a href="{{ route('attendance/user',  $user->id) }}" class="btn btn-primary">勤怠表</></td>
            </tr>
                @php
                    $pageNumber++;
                @endphp
            @endforeach
        </table>
    </div>
    {{ $users->appends(['search' => request('search')])->links('vendor/pagination/paginate') }}
@endsection