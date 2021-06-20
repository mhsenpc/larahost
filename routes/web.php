<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sites', App\Http\Controllers\SiteController::class);
    Route::prefix('sites')->group(function () {
        Route::get('/start',[\App\Http\Controllers\SiteController::class,'start'])->name('sites.start');
        Route::get('/stop',[\App\Http\Controllers\SiteController::class,'stop'])->name('sites.stop');
        Route::get('/restart',[\App\Http\Controllers\SiteController::class,'restart'])->name('sites.restart');
    });
});
