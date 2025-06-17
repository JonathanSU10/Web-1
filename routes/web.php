<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramUmrohController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LogAkunController;
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
Route::post('regist', [UserController::class, 'insertRegis'])->name('regist');
Route::post('regist', [LogAkunController::class, 'store']);
/**
 * socialite auth
 */
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    //akun
    Route::get('/profile', [LogAkunController::class, 'dataprofil'])->name("profile");
    Route::post('/edit-profile', [LogAkunController::class, 'editprofil']);
    Route::post('/edit-pw', [LogAkunController::class, 'editakun']);

    //user/pengguna
    Route::get('/data-user', [UserController::class, 'datauser'])->name('data-user');
    Route::post('/save-user', [UserController::class, 'simpanuser']);
    Route::get('/edit-user/{user_id}', [UserController::class, 'edituser'])->name('edit-user');
    Route::post('/edit-pw-user', [UserController::class, 'editakun'])->name("edit-pw-user");
    Route::post('/update-user/{user_id}', [UserController::class, 'updateuser'])->name('update-user');
    Route::get('/delete-user/{user_id}', [UserController::class, 'hapususer'])->name('delete-user');

    //paket
    Route::get('/data-paket', [ProgramUmrohController::class, 'datapaket'])->name('data-paket');
    Route::post('/save-paket', [ProgramUmrohController::class, 'simpanpaket']);
    Route::post('/update-paket/{id_paket}', [ProgramUmrohController::class, 'updatepaket']);
    Route::get('/delete-paket/{id_paket}', [ProgramUmrohController::class, 'hapuspaket']);
    
    

    //pendaftaran
    Route::get('/data-registration', [PendaftaranController::class, 'datapendaftaran'])->name('data-registration');
    Route::get('/form-registration', [PendaftaranController::class, 'inputpendaftaran']);
    Route::post('/save-registration', [PendaftaranController::class, 'simpanpendaftaran']);
    Route::get('/edit-registration/{id_pendaftaran}', [PendaftaranController::class, 'editpendaftaran']);
    Route::post('/update-registration/{id_pendaftaran}', [PendaftaranController::class, 'updatependaftaran']);
    Route::get('/delete-registration/{id_pendaftaran}', [PendaftaranController::class, 'hapuspendaftaran']);
    Route::get('/detail-registration/{id_pendaftaran}', [PendaftaranController::class, 'detailpendaftaran']);
    Route::get('/card-registration/{id_pendaftaran}', [PendaftaranController::class, 'kartupendaftaran']);
    Route::get('/pendaftaran/print', [PendaftaranController::class, 'print'])->name('pendaftaran.print');

    Route::get('/verified-registration/{id_pendaftaran}', [PendaftaranController::class, 'verifikasistatuspendaftaran']);
    Route::get('/notverified-registration/{id_pendaftaran}', [PendaftaranController::class, 'notverifikasistatuspendaftaran']);
    Route::get('/invalid-registration/{id_pendaftaran}', [PendaftaranController::class, 'invalidstatuspendaftaran']);
    Route::get('/finish-registration/{id_pendaftaran}', [PendaftaranController::class, 'selesaistatuspendaftaran']);

    //pembayaran
    Route::get('/data-payment', [PembayaranController::class, 'datapembayaran'])->name('data-pembayaran');
    Route::post('/save-payment', [PembayaranController::class, 'simpanpembayaran']);
    Route::post('/update-payment/{id_pembayaran}', [PembayaranController::class, 'updatepembayaran']);
    Route::get('/delete-payment/{id_pembayaran}', [PembayaranController::class, 'hapuspembayaran']);
    Route::get('/pembayaran/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
    Route::get('invoice/{id}', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');

    Route::post('/upload-payment', [PembayaranController::class, 'updatebuktipembayaran'])->name('upload-payment');
    Route::get('/paid-payment/{id_pembayaran}', [PembayaranController::class, 'verifikasipembayaran']);
    Route::get('/unpaid-payment/{id_pembayaran}', [PembayaranController::class, 'belumbayar']);
    Route::get('/invalid-payment/{id_pembayaran}', [PembayaranController::class, 'invalidbayar']);


});

require __DIR__ . '/auth.php';
