<?php

use App\Http\Controllers\CommandsController;
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
        Route::post('deploy_commands', [SiteController::class, 'save_deploy_commands'])->name('sites.save_deploy_commands');
        Route::post('remove', [SiteController::class, 'remove'])->name('sites.remove');
        Route::get('restart', [SiteController::class, 'restartAll'])->name('sites.restart_all');
        Route::get('redeploy', [SiteController::class, 'redeploy'])->name('sites.redeploy');
        Route::get('env_editor', [SiteController::class, 'env_editor'])->name('sites.env_editor');
        Route::post('handle_env_editor', [SiteController::class, 'handle_env_editor'])->name('sites.handle_env_editor');
        Route::get('regenerate_deploy_token', [SiteController::class, 'regenerateDeployToken'])->name('sites.regenerate_deploy_token');
        Route::post('maintenance_up', [SiteController::class, 'maintenanceUp'])->name('sites.maintenance_up');
        Route::post('maintenance_down', [SiteController::class, 'maintenanceDown'])->name('sites.maintenance_down');
        Route::post('update_git_remote', [SiteController::class, 'updateGitRemote'])->name('sites.update_git_remote');

        Route::get('/commands', [CommandsController::class, 'index'])->name('sites.commands');
        Route::post('/exec_command', [CommandsController::class, 'execCommand'])->name('sites.exec_command');
    });

    Route::get('deployments/{deployment_id}/log', [DeploymentController::class, 'showLog'])->name('deployments.showLog');
    Route::get('deployments/{site_id}/lastDeploymentLog', [DeploymentController::class, 'lastDeploymentLog'])->name('deployments.lastDeploymentLog');
    Route::get('logs/{site_name}/{file_name}', [LogController::class, 'showLog'])->name('logs.show');
});
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::any('trigger_deployment', [App\Http\Controllers\SiteController::class, 'triggerDeployment'])->name('triggerDeployment');

