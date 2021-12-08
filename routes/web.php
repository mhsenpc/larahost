<?php

use App\Events\Site\DeployFailed;
use App\Http\Controllers\CommandsController;
use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\SiteController;
use App\Models\Site;
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

Route::get('/test',function(){
          $message="Failed to clone the repository with the provided credentials";
          event(new DeployFailed(Site::first(),$message));
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sites', App\Http\Controllers\SiteController::class);
    Route::prefix('sites/{site}')->group(function () {
        Route::get('deployments', [SiteController::class, 'deployments'])->name('sites.deployments');
        Route::get('logs', [SiteController::class, 'logs'])->name('sites.logs');
        Route::post('deploy_commands', [SiteController::class, 'save_deploy_commands'])->name('sites.save_deploy_commands');
        Route::post('remove', [SiteController::class, 'remove'])->name('sites.remove');
        Route::get('sites.factory_reset', [SiteController::class, 'factoryReset'])->name('sites.factory_reset');
        Route::get('redeploy', [SiteController::class, 'redeploy'])->name('sites.redeploy');
        Route::get('env_editor', [SiteController::class, 'env_editor'])->name('sites.env_editor');
        Route::post('handle_env_editor', [SiteController::class, 'handle_env_editor'])->name('sites.handle_env_editor');
        Route::get('regenerate_deploy_token', [SiteController::class, 'regenerateDeployToken'])->name('sites.regenerate_deploy_token');
        Route::post('maintenance_up', [SiteController::class, 'maintenanceUp'])->name('sites.maintenance_up');
        Route::post('maintenance_down', [SiteController::class, 'maintenanceDown'])->name('sites.maintenance_down');
        Route::post('update_git_remote', [SiteController::class, 'updateGitRemote'])->name('sites.update_git_remote');
        Route::get('restart_apache', [SiteController::class, 'restartApache'])->name('sites.restart_apache');
        Route::get('restart_mysql', [SiteController::class, 'restartMySql'])->name('sites.restart_mysql');
        Route::get('restart_redis', [SiteController::class, 'restartRedis'])->name('sites.restart_redis');
        Route::get('restart_supervisor', [QueueController::class, 'restartSupervisor'])->name('sites.restart_supervisor');

        Route::get('commands', [CommandsController::class, 'index'])->name('sites.commands');
        Route::post('exec_command', [CommandsController::class, 'execCommand'])->name('sites.exec_command');

        Route::get('domains', [DomainController::class, 'index'])->name('sites.domains');
        Route::post('park_domain', [DomainController::class, 'parkDomain'])->name('sites.park_domain');
        Route::get('remove_domain', [DomainController::class, 'removeDomain'])->name('sites.remove_domain');
        Route::get('enable_sub_domain', [DomainController::class, 'enableSubDomain'])->name('sites.enable_sub_domain');
        Route::get('disable_sub_domain', [DomainController::class, 'disableSubDomain'])->name('sites.disable_sub_domain');

        Route::get('workers', [QueueController::class, 'index'])->name('sites.workers');
        Route::post('create_worker', [QueueController::class, 'createWorker'])->name('sites.create_worker');
        Route::get('remove_worker/{worker_id}', [QueueController::class, 'removeWorker'])->name('sites.remove_worker');
        Route::get('restart_worker/{worker_id}', [QueueController::class, 'restartWorker'])->name('sites.restart_worker');
        Route::get('get_workers_status', [QueueController::class, 'getWorkersStatus'])->name('sites.get_workers_status');
        Route::get('get_worker_log/{worker_id}', [QueueController::class, 'getWorkerLog'])->name('sites.get_worker_log');
    });

    Route::get('deployments/{deployment_id}/log', [DeploymentController::class, 'showLog'])->name('deployments.showLog');
    Route::get('deployments/{site_id}/lastDeploymentLog', [DeploymentController::class, 'lastDeploymentLog'])->name('deployments.lastDeploymentLog');
    Route::get('logs/{site_name}/{file_name}', [LogController::class, 'showLog'])->name('logs.show');

    Route::get('search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');

    Route::middleware([\App\Http\Middleware\AdminChecker::class])->group(function () {
        Route::get('admin/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users.index');
        Route::get('admin/users/loginAs/{user_id}', [\App\Http\Controllers\Admin\UsersController::class, 'loginAs'])->name('admin.users.loginAs');
        Route::get('admin/domains', [\App\Http\Controllers\Admin\DomainsController::class, 'index'])->name('admin.domains.index');
        Route::get('admin/sites', [\App\Http\Controllers\Admin\SitesController::class, 'index'])->name('admin.sites.index');
    });
});
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::any('trigger_deployment', [App\Http\Controllers\SiteController::class, 'triggerDeployment'])->name('triggerDeployment');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
