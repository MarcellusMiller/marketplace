<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;



// rotas admin
Route::controller(AdminController::class)->group(function() {
    Route::get('admin/dashboard','dashboard')
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');
});


