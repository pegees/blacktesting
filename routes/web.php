<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;


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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::resource('suppliers', SupplierController::class);

Route::resource('pelanggans', PelangganController::class);

Route::resource('barangs', BarangController::class);

Route::resource('kategoris', KategoriController::class);

Route::resource('satuans', SatuanController::class);


Route::prefix('pembelian')->name('pembelian.')->group(function () {
    Route::get('/', [PembelianController::class, 'index'])->name('index');
    Route::get('/create', [PembelianController::class, 'create'])->name('create');
    Route::post('/', [PembelianController::class, 'store'])->name('store');
    Route::get('/{pembelian}', [PembelianController::class, 'show'])->name('show');
    Route::delete('/{pembelian}', [PembelianController::class, 'destroy'])->name('destroy');
});

Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('create');
    Route::post('/', [TransaksiController::class, 'store'])->name('store');
    Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('destroy');
});

});


require __DIR__.'/auth.php';
