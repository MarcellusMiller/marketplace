<?php 

use App\Http\Controllers\Backend\VendorController;
use Illuminate\Support\Facades\Route;

// Rota Vendedor
Route::controller(VendorController::class)->group(function() {
    
    Route::get('vendor/dashboard', 'dashboard')
    ->middleware(['auth', 'vendor'])
    ->name('vendor.dashboard');
});

