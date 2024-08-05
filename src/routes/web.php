<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/work', [AttendanceController::class, 'work'])
    ->name('work');
    Route::get('/attendance/date', [AttendanceController::class, 'indexDate'])
    ->name('attendance/date');
    Route::post('/attendance/date',[AttendanceController::class, 'perDate'])
    ->name('per/date');
});

Route::get('/attendance/user', [AttendanceController::class, 'indexUser'])
->name('attendance/user');
Route::post('/attendance/user', [AttendanceController::class, 'perUser'])
->name('per/user');
Route::get('/user', [AttendanceController::class, 'user'])
    ->name('user');
