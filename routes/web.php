<?php

use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\LogController;
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
    Route::prefix('sites/{site}')->group(function () {
        Route::get('deployments', [SiteController::class, 'deployments'])->name('sites.deployments');
        Route::get('logs', [SiteController::class, 'logs'])->name('sites.logs');
        Route::get('deploy_commands', [SiteController::class, 'deploy_commands'])->name('sites.deploy_commands');
        Route::post('deploy_commands', [SiteController::class, 'save_deploy_commands'])->name('sites.save_deploy_commands');
        Route::post('destroy', [SiteController::class, 'destroy'])->name('sites.remove');
        Route::get('start', [SiteController::class, 'start'])->name('site.start');
        Route::get('stop', [SiteController::class, 'stop'])->name('site.stop');
        Route::get('restart', [SiteController::class, 'restart'])->name('site.restart');
        Route::get('redeploy', [SiteController::class, 'redeploy'])->name('site.redeploy');
    });

    Route::get('deployments/{id}/log', [DeploymentController::class, 'showLog'])->name('deployments.showLog');
    Route::get('logs/{project_name}/{file_name}', [LogController::class, 'showLog'])->name('logs.show');
});
