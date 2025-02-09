<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::get('/', [AuthController::class, 'login'])->name('login');
route::get('/register', [AuthController::class, 'register'])->name('register');
route::post('/logout', [AuthController::class, 'logout'])->name('logout');
route::post('/login/auth', [AuthController::class, 'postlogin'])->name('login.post');
route::post('/register/auth', [AuthController::class, 'postregister'])->name('register.post');

Route::get('/users', [AuthController::class, 'index'])->name('users.index');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');

Route::middleware('auth')->group(function(){
    //view
    route::get('/dashboard', [BarangController::class, 'index'])->name('dashboard');
    route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
    route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
    route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
    route::get('/users', [AuthController::class, 'index'])->name('users');

    //details
    route::get('/pembelian/details/{id}', [PembelianDetailController::class, 'index'])->name('pembelian.detail');
    route::get('/penjualan/details/{id}', [PenjualanDetailController::class, 'index'])->name('penjualan.detail');
    route::get('/pembelian-detail/export', [PembelianDetailController::class, 'export'])->name('pembelian.export');

    //store
    route::post('/barang/post', [BarangController::class, 'store'])->name('barang.store');
    route::post('/kategori/post', [KategoriController::class, 'store'])->name('kategori.store');
    route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    route::post('/pembelian/store', [PembelianDetailController::class, 'store'])->name('pembelian.store');
    route::post('/penjualan/store', [PenjualanDetailController::class, 'store'])->name('penjualan.store');

    //update
    route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');

    //destroy
    route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
    route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');
    route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
    route::get('/barang/{id}/confirm-delete', [BarangController::class, 'confirmDelete'])->name('barang.confirm-delete');
});
