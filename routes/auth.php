<?php

use App\Http\Controllers\Auth\NewPasswordController;

Route::middleware('guest')->group(function (){
   Route::get('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'create'])->name('forgot-password');
   Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'store'])->name('forgot-password');

    Route::get('password/reset/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('password/reset', [NewPasswordController::class, 'store'])
        ->name('password.store');
});
