<?php

use App\Http\Controllers\SiteController;
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
    Route::get('sites/{site_id}/deployments',[SiteController::class,'deployments'])->name('sites.deployments');
    Route::post('sites/{id}/destroy',[SiteController::class,'destroy'])->name('sites.remove');
    Route::prefix('site')->group(function () {
        Route::get('/start',[SiteController::class,'start'])->name('site.start');
        Route::get('/stop',[SiteController::class,'stop'])->name('site.stop');
        Route::get('/restart',[SiteController::class,'restart'])->name('site.restart');
    });

    Route::get('deployments/{id}/log',[\App\Http\Controllers\DeploymentController::class,'showLog'])->name('deployments.showLog');
});
