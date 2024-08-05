@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="header__wrap">
        <p class="header__text">ユーザー一覧</p>
        <p class="header__text-right">{{ $displayDate->format('Y-m-d') }} 現在</p>
    </div>
    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">ID</th>
                <th class="table__header">名前</th>
            </tr>
            @php
                $pageNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
            @endphp
            @foreach ($users as $user)
                <tr class="table__row">
                    <td class="table__item">{{ $user->id }}</td>
                    <td class="table__item">{{ $user->name }}</td>
                </tr>
                @php
                    $pageNumber++;
                @endphp
            @endforeach
        </table>
    </div>
    {{ $users->links('vendor/pagination/paginate') }}
@endsection