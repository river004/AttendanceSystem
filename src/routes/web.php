<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('verified')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/work', [AttendanceController::class, 'work'])
    ->name('work');
    Route::get('/attendance/{date}', [AttendanceController::class, 'indexDate'])
    ->name('attendance/date');
    Route::post('/attendance/date',[AttendanceController::class, 'perDate']);
    Route::get('/attendance/user', [AttendanceController::class, 'indexUser'])
->name('attendance/user');
Route::post('/attendance/user', [AttendanceController::class, 'perUser'])
->name('per/user');
Route::get('/user', [AttendanceController::class, 'user'])
    ->name('user');

});

