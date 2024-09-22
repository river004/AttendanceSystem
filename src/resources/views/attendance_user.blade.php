@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendance_user.css') }}">
@endsection

@section('content')
<div class="header__text">
<h3 >{{ $user->name }} さんの勤怠表</h3>
</div>
<div class="header__wrap">
    <a href="{{ route('attendance/user', ['id' => $user->id, 'month' => $previousMonth]) }}" class="date__change-button"><</a>
    <h3 class="header__month">({{ $currentMonth }})</h3>
    <a href="{{ route('attendance/user', ['id' => $user->id, 'month' => $nextMonth]) }}" class="date__change-button">></a>
</div>
<div class="table__wrap">
    <table class="attendance__table">
        <tr class="table__row">
            <th class="table__header">日付</th>
            <th class="table__header">勤務開始</th>
            <th class="table__header">勤務終了</th>
            <th class="table__header">休憩時間</th>
            <th class="table__header">勤務時間</th>
        </tr>
        @foreach ($users as $user)
            <tr class="table__row">
                <td class="table__item">{{ $user->date }}</td>
                <td class="table__item">{{ $user->start_work }}</td>
                <td class="table__item">{{ $user->end_work }}</td>
                <td class="table__item">{{ $user->total_rest }}</td>
                <td class="table__item">{{ $user->total_work }}</td>
            </tr>
        @endforeach
    </table>
{{ $users->appends(['month' => $currentMonth])->links('vendor/pagination/default') }}
@endsection