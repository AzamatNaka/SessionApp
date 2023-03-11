<?php

use App\Http\Controllers\Auth2\LoginController;
use App\Http\Controllers\Auth2\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/sessions', [UserController::class, 'store'])->name('sessions.store');
    Route::get('/sessions', [UserController::class, 'index'])->name('sessions.index');
    Route::put('/sessions/{session}', [UserController::class, 'endSession'])->name('sessions.endsession');
    Route::get('sessions/all', [UserController::class, 'EndAllSessions'])->name('sessions.endallsessions');

    Route::put('/sessions/end-all-sessions-except-current/{session}', [UserController::class, 'endAllSessionsExceptCurrent'])
        ->name('sessions.endallsessionsexceptcurrent');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


//Auth::routes();
Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'create'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
