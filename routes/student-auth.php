<?php

use App\Http\Controllers\Student\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware('guest:student')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('student.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('student.user-login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    
});

Route::prefix('student')->middleware('auth:student')->group(function () {

    Route::get('/uniforms', function () {
        return view('pages.uniforms');
    })->name('pages.uniforms');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('student.logout');
});
