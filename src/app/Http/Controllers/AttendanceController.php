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

    public function indexDate($date)
    {
        // パラメータが渡されていない場合、今日の日付を使用
        if (is_null($date)) {
            $date = Carbon::today()->toDateString();
        }
        // 日付が正しい形式かチェックし、無効なら今日の日付を使用
        $currentDate = Carbon::createFromFormat('Y-m-d', $date, null)->startOfDay() ?: Carbon::today();

        // 日付に基づいたデータを取得し、5件ずつページネート
        $users = DB::table('attendance_view_table')->whereDate('date', $currentDate)->paginate(5);

        // 前日と翌日の日付を取得
        $previousDate = $currentDate->copy()->subDay()->toDateString();
        $nextDate = $currentDate->copy()->addDay()->toDateString();

        return view('attendance_date', compact('users', 'currentDate', 'previousDate', 'nextDate', 'date'));
    }

    public function user(Request $request)
    {
        // 検索クエリ
        $search = $request->input('search');

        // 検索クエリの作成
        $query = User::query();

         // ユーザーIDかユーザー名で検索する
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // ページネーションを適用してユーザーリストを取得
        $users = $query->paginate(5);

        return view('user', compact('users', 'search'));
    }

    public function indexUser(Request $request, $userId)
    {
        // 月の指定があれば取得、なければ現在の月を使用
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // ユーザー情報を取得
        $user = User::findOrFail($userId);

        // 指定した月の勤怠データを取得
        $users = DB::table('attendance_view_table')->where('id', $userId)
        ->where('date', 'like', "{$currentMonth}%")->paginate(31);

        // 月の前後のリンク用データを生成
        $currentMonthDate = Carbon::createFromFormat('Y-m', $currentMonth);
        $previousMonth = $currentMonthDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonthDate->copy()->addMonth()->format('Y-m');

        return view('attendance_user', compact('users', 'currentMonth', 'user', 'previousMonth', 'nextMonth'));
    }
}
