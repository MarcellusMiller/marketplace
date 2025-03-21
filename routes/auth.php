<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Rotas para registro
    Route::controller(RegisteredUserController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    // Rotas para login
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });

    // Rotas para recuperação de senha
    Route::controller(PasswordResetLinkController::class)->group(function () {
        Route::get('forgot-password', 'create')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
    });

    Route::controller(NewPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password', 'store')->name('password.store');
    });
});

Route::middleware('auth')->group(function () {
    // Verificação de e-mail
    Route::controller(EmailVerificationPromptController::class)->group(function () {
        Route::get('verify-email')->name('verification.notice');
    });

    Route::controller(VerifyEmailController::class)->group(function () {
        Route::get('verify-email/{id}/{hash}')
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
    });

    Route::controller(EmailVerificationNotificationController::class)->group(function () {
        Route::post('email/verification-notification', 'store')
            ->middleware('throttle:6,1')
            ->name('verification.send');
    });

    // Confirmação de senha
    Route::controller(ConfirmablePasswordController::class)->group(function () {
        Route::get('confirm-password', 'show')->name('password.confirm');
        Route::post('confirm-password', 'store');
    });

    // Atualização de senha
    Route::controller(PasswordController::class)->group(function () {
        Route::put('password', 'update')->name('password.update');
    });

    // Logout
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::post('logout', 'destroy')->name('logout');
    });
});
