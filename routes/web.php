<?php

use App\Http\Controllers\BarangController;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MultipleController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PembelianController;

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
    return view('welcome');
});



Route::get('/create', [PembelianController::class, 'create']);
Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');

Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
Route::post('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

Route::get('/barang', [PembelianController::class, 'barang']);
Route::post('/save-pembelian', [PembelianController::class, 'store'])->name('save-pembelian');


















Route::get('/products', [ProductController::class, 'index'])->name('products.index');














