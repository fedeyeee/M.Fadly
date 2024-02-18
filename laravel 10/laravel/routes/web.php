<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PetugasController;
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

Route::get('/', function () {
    return view('login');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('login','index')->name('login');
    Route::post('login/proses','proses');
    Route::get('logout','logout');
});

Route::group(['middleware' => ['cekUserLogin:1']], function () {
    // Tambahkan route manual untuk resource dan store
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/admin-store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-stok', [AdminController::class, 'stok'])->name('admin.stok');
    Route::post('/admin-stok-update', [AdminController::class, 'stokupdate'])->name('admin.stok-update');
    
    // ... tambahkan route lain sesuai kebutuhan
    Route::post('produk/create', [AdminController::class, 'create'])->name('admin');
    Route::get('edit/{id}/', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('del/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('admin/barang/update', [AdminController::class, 'update'])->name('admin.barang.update');
    Route::get('admin-user/{id}', [AdminController::class, 'showuser'])->name('admin.showuser');
    Route::post('admin-useru', [AdminController::class, 'updateuser'])->name('admin.updateuser');
    Route::get('admin-user-del/{id}', [AdminController::class, 'destroyuser'])->name('admin.destroyuser');
});

Route::group(['middleware' => ['cekUserLogin:2']],function(){
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/petugas-create', [PetugasController::class, 'create'])->name('petugas.create');
    Route::get('/petugas-destroy{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
    Route::get('petugas-edit/{id}/', [AdminController::class, 'edit'])->name('petugas.edit');
    Route::post('/petugas-update', [PetugasController::class, 'update'])->name('petugas.update');
    Route::get('/petugas-stok', [PetugasController::class, 'stok'])->name('petugas.stok');
    Route::post('/petugas-stok-update', [PetugasController::class, 'stokupdate'])->name('petugas.stok-update');
    // ... tambahkan route lain sesuai kebutuhan

});

