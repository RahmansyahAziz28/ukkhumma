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
route::post('/logout', [AuthController::class, 'logout'])->name('logout');
route::post('/login/auth', [AuthController::class, 'postlogin'])->name('login.post');
Route::get('/users', [AuthController::class, 'index'])->name('users.index');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BarangController::class, 'index'])->name('dashboard');

    Route::middleware(['role:member'])->group(function () {
        Route::get('/history', [PenjualanController::class, 'index'])->name('history');
        Route::get('/penjualan/details/{id}', [PenjualanDetailController::class, 'index'])->name('penjualan.detail');
    });


    Route::middleware(['role:admin'])->group(function () {
        //view
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
        Route::get('/users', [AuthController::class, 'index'])->name('users');
        Route::get('/pembelian/details/{id}', [PembelianDetailController::class, 'index'])->name('pembelian.detail');
        Route::get('/pembelian-detail/export', [PembelianDetailController::class, 'export'])->name('pembelian.export');

        //store
        Route::post('/barang/post', [BarangController::class, 'store'])->name('barang.store');
        Route::post('/barang/new', [BarangController::class, 'new'])->name('barang.new');
        Route::post('/kategori/post', [KategoriController::class, 'store'])->name('kategori.store');
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::post('/pembelian/store', [PembelianDetailController::class, 'store'])->name('pembelian.store');
        Route::post('/register/auth', [AuthController::class, 'postregister'])->name('register.post');

        //update
        Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');

        //destroy
        Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
        Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');
        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
        Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
        Route::get('/barang/{id}/confirm-delete', [BarangController::class, 'confirmDelete'])->name('barang.confirm-delete');
    });

    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/register', [AuthController::class, 'index'])->name('register');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
        Route::get('/penjualan/details/{id}', [PenjualanDetailController::class, 'index'])->name('penjualan.detail');
        Route::post('/penjualan/store', [PenjualanDetailController::class, 'store'])->name('penjualan.store');
        Route::post('/register/auth', [AuthController::class, 'postregister'])->name('register.post');
    });

    Route::middleware(['role:pimpinan'])->group(function () {
        //view
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
        Route::get('/users', [AuthController::class, 'index'])->name('users');
        Route::get('/pembelian/details/{id}', [PembelianDetailController::class, 'index'])->name('pembelian.detail');
        Route::get('/pembelian-detail/export', [PembelianDetailController::class, 'export'])->name('pembelian.export');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
        Route::get('/penjualan/details/{id}', [PenjualanDetailController::class, 'index'])->name('penjualan.detail');

        //store
        Route::post('/barang/post', [BarangController::class, 'store'])->name('barang.store');
        Route::post('/barang/new', [BarangController::class, 'new'])->name('barang.new');
        Route::post('/kategori/post', [KategoriController::class, 'store'])->name('kategori.store');
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::post('/pembelian/store', [PembelianDetailController::class, 'store'])->name('pembelian.store');
        Route::post('/penjualan/store', [PenjualanDetailController::class, 'store'])->name('penjualan.store');
        Route::post('/register/auth', [AuthController::class, 'postregister'])->name('register.post');

        //update
        Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');

        //destroy
        Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
        Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');
        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
        Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
        Route::get('/barang/{id}/confirm-delete', [BarangController::class, 'confirmDelete'])->name('barang.confirm-delete');
    });
});
