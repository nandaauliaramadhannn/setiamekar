<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MobilitasController;
use App\Http\Controllers\RenstraController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
});

