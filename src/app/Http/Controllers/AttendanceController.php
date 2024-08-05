<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;


class AttendanceController extends Controller
{
    public function index()
    {
        $now_date = Carbon::now()->format('Y-m-d');
        $user_id = Auth::user()->id;
        $confirm_date = Work::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();

        if (!$confirm_date) {
            $status = 0;
        } else {
            $status = Auth::user()->status;
        }
        return view('index', compact('status'));
    }

    public function work(Request $request)
    {
        $now_date = Carbon::now()->format('Y-m-d');
        $now_time = Carbon::now()->format('H:i:s');
        $user_id = Auth::user()->id;
        if ($request->has('start_rest') || $request->has('end_rest')) {
            $work_id = Work::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first()
                ->id;
        }

        if ($request->has('start_work')) {
            $attendance = new Work();
            $attendance->date = $now_date;
            $attendance->start_work = $now_time;
            $attendance->user_id = $user_id;
            $status = 1;
        }

        if ($request->has('start_rest')) {
            $attendance = new Rest();
            $attendance->start_rest = $now_time;
            $attendance->work_id = $work_id;
            $status = 2;
        }

        if ($request->has('end_rest')) {
            $attendance = Rest::where('work_id', $work_id)
                ->whereNotNull('start_rest')
                ->whereNull('end_rest')
                ->first();
            $attendance->end_rest = $now_time;
            $status = 1;
        }

        if ($request->has('end_work')) {
            $attendance = Work::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first();
            $attendance->end_work = $now_time;
            $status = 3;
        }

        $user = User::find($user_id);
        $user->status = $status;
        $user->save();

        $attendance->save();

        return redirect('/')->with(compact('status'));
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function indexDate(Request $request)
    {
        $displayDate = Carbon::now();

        $users = DB::table('attendance_view_table')
            ->whereDate('date', $displayDate)
            ->paginate(5);

        return view('attendance_date', compact('users', 'displayDate'));
    }

    public function perDate(Request $request)
    {
        $displayDate = Carbon::parse($request->input('displayDate'));

        if ($request->has('prevDate')) {
            $displayDate->subDay();
        }

        if ($request->has('nextDate')) {
            $displayDate->addDay();
        }

        $users = DB::table('attendance_view_table')
            ->whereDate('date', $displayDate)
            ->paginate(5);

        return view('attendance_date', compact('users', 'displayDate'));
    }

    public function indexUser(Request $request)
    {
        $displayUser = Auth::user()->name;
        $users = DB::table('attendance_view_table')
            ->where('name', $displayUser)
            ->paginate(5);
        $userList = User::all();

        return view('attendance_user', compact('users', 'displayUser', 'userList'));
    }

    public function perUser(Request $request)
    {
        $searchName = $request->input('search_name');
        $user = User::where('name', $searchName)->first();
        $displayUser = $user ? $user->name : null;

        $users = DB::table('attendance_view_table')
            ->where('name', $searchName)
            ->paginate(5);

        $userList = User::all();

        return view('attendance_user', compact('users', 'displayUser', 'userList'));
    }
    public function user()
    {
        $users = User::paginate(5);
        $displayDate = Carbon::now();

        return view('user', compact('users', 'displayDate'));
    }
}
