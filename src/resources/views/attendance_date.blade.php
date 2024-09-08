@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <div class="header__wrap">
        <p class="header__text">Attendance for {{ $currentDate->toDateString() }}</p>
    </div>
    <div class="table__wrap">
        <table class="attendance__table">
            <tr class="table__row">
                <th class="table__header">名前</th>
                <th class="table__header">勤務開始</th>
                <th class="table__header">勤務終了</th>
                <th class="table__header">休憩時間</th>
                <th class="table__header">勤務時間</th>
            </tr>
            @foreach ($users as $user)
                <tr class="table__row">
                    <td class="table__item">{{ $user->name }}</td>
                    <td class="table__item">{{ $user->start_work }}</td>
                    <td class="table__item">{{ $user->end_work }}</td>
                    <td class="table__item">{{ $user->total_rest }}</td>
                    <td class="table__item">{{ $user->total_work }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    {{ $users->links('vendor/pagination/default') }}
    <div class="d-flex justify-content-between mt-3">
        <a class="date__change-button" href="{{ route('attendance/date', $previousDate) }}" class="btn btn-primary"><</a>
        <a class="date__change-button" href="{{ route('attendance/date', $nextDate) }}" class="btn btn-primary">></a>
    </div>
@endsection