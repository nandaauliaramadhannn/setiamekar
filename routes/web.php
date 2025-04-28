<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MobilitasController;
use App\Http\Controllers\MobilitasReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});


Route::group(['middleware' => ['guest']], function () {
Route::get('auth/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/backend/index/resntra/view/doc', [RenstraController::class, 'indexrenstra'])->name('backend.index.renstra');
    Route::get('/backend/mobilitas/pegawai/index', [MobilitasController::class, 'indexmobilitas'])->name('backend.mobilitas.pegawa.index');
    Route::get('backend/add/mobilitas/pegawai',[MobilitasController::class, 'create'])->name('mobilitas.create');
    Route::post('backend/store/mobilitas/pegawai', [MobilitasController::class, 'store'])->name('mobilitas.store');
    Route::get('/data/pie/chart', [DashboardController::class, 'chartpie'])->name('data.pie.chart');
    Route::get('/profile', [AuthController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/edit', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    Route::get('/mobilitas/chart-data', [MobilitasReportController::class, 'chartData']);
});


Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/backend/user/index', [AuthController::class, 'userindex'])->name('admin.backend.user.index');
     Route ::get ('/backend/add/user', [ AuthController::class, 'createform'])->name('admin.backend.user.create');
    Route::post('backend/store/user', [AuthController::class, 'storeuser'])->name('admin.backend.user.store');
    Route::get('/backend/edit/user/{id}', [AuthController::class, 'edit'])->name('admin.backend.user.edit');
    Route::post('backend/update/user/{id}', [AuthController::class, 'updateuser'])->name('admin.backend.user.update');
    Route::delete('backend/delete/user/{id}', [AuthController::class, 'destroy'])->name('admin.backend.user.destroy');
    Route::post('/backend/add/document/renstra', [RenstraController::class, 'store'])->name('admin.backend.add.document.renstra');
    Route::delete('/admin/backend/document/renstra/{id}', [RenstraController::class, 'destroy'])->name('admin.backend.delete.document.renstra');
    Route::post('/mobilitas/{id}/verifikasi', [MobilitasController::class, 'verifikasi'])->name('mobilitas.verifikasi');
Route::post('/mobilitas/{id}/tolak', [MobilitasController::class, 'tolak'])->name('mobilitas.tolak');
    Route::get('/mobilitas/{id}/show', [MobilitasController::class, 'show'])->name('mobilitas.show');
    Route::get('/mobilitas/report/pegawai/', [MobilitasController::class, 'report'])->name('mobilitas.report');
    Route::get('/mobilitas/report-pdf', [MobilitasController::class, 'reportPdf'])->name('mobilitas.report-pdf');
    Route::get('/{id}/edit', [MobilitasController::class, 'edit'])->name('mobilitas.edit');
    Route::put('/{id}', [MobilitasController::class, 'update'])->name('mobilitas.update');
    // Route::get('/mobilitas/chart-data', [MobilitasReportController::class, 'chartData']);
});

