<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SppController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RefAgamaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\RefKabupatenController;
use App\Http\Controllers\RefKecamatanController;
use App\Http\Controllers\RefKelurahanController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ConfigurasiUserController;

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
Route::get('/', function(){
    return view('welcome');
})->name('index');

Route::middleware(['guest'])->group(function () {
    Route::get('/register',[App\Http\Controllers\User\SekolahController::class, 'create'])->name('register');
    Route::post('/register', [App\Http\Controllers\User\SekolahController::class, 'store'])->name('register.store');
});

Route::prefix('data-master')->group(function () {
    Route::post('kabupaten', [RefKabupatenController::class, 'index'])->name('kabupaten_list');
    Route::post('kecamatan', [RefKecamatanController::class, 'index'])->name('kecamatan_list');
    Route::post('kelurahan', [RefKelurahanController::class, 'index'])->name('kelurahan_list');
    Route::post('/get-data', [KelasController::class, 'get_data'])->name('kelas.get_data');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RoleController::class);

    Route::get('edit/sekolah', [App\Http\Controllers\User\SekolahController::class, 'edit'])->name('sekolah.edit.own');
    Route::patch('update/sekolah', [App\Http\Controllers\User\SekolahController::class, 'update'])->name('sekolah.update.own');
    Route::prefix('data-master')->group(function () {
        Route::middleware(['auth.sma_smk'])->group(function () {
            Route::resource('kompetensi', KompetensiController::class);
        });
        Route::post('kelas/upgrade', [KelasController::class, 'upgrade'])->name('kelas.upgrade');
        Route::resource('kelas', KelasController::class);
        Route::resource('agama', RefAgamaController::class);
        Route::resource('spp', SppController::class);
        Route::resource('tahun-ajaran', TahunAjaranController::class);
    });
       
    Route::post('/users/siswa/{id}/down', [UserController::class, 'down'])->name('users.down');
    
    Route::middleware(['check_role'])->group(function () {
        Route::name('users.')->prefix('users')->group(function () {
            // Route::resource('siswa', SiswaController::class);
            Route::get('{role}', [UserController::class, 'index'])->name('index');
            Route::post('{role}/list', [UserController::class, 'list'])->name('list');
            Route::get('{role}/create', [UserController::class, 'create'])->name('create');
            Route::post('{role}', [UserController::class, 'store'])->name('store');
            Route::get('{role}/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::get('{role}/{id}', [UserController::class, 'show'])->name('shows');
            Route::patch('{role}/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('{role}/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Export dan Import User
        Route::get('/import/users/{role}', [UserController::class, 'import']);
        Route::post('/import/users/{role}', [UserController::class, 'store_import']);
        Route::get('/export/users/{role}', [UserController::class, 'export']);
    });

    Route::resource('sekolah', App\Http\Controllers\SekolahController::class);

    // Pembayaran SPP
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::post('/export/excel', [PembayaranController::class, 'export_all'])->name('export_all');
        Route::get('/export/{user_id}', [PembayaranController::class, 'export'])->name('export');
        Route::get('create/{user_id}', [PembayaranController::class, 'create'])->name('create');
        Route::get('{user_id}', [PembayaranController::class, 'show'])->name('show');
        Route::post('{user_id}', [PembayaranController::class, 'store'])->name('store');
        Route::delete('{pembayaran_id}/{user_id}', [PembayaranController::class, 'destroy'])->name('destroy');
    });

     // Profil
    Route::prefix('profil')->name('profil.')->group(function () {
         Route::get('/', [ConfigurasiUserController::class, 'index'])->name('index');
         Route::patch('/update', [ConfigurasiUserController::class, 'update'])->name('update');
         Route::get('/ubah-password', [ConfigurasiUserController::class, 'ubahPassword'])->name('ubah-password');
         Route::patch('/reset-password', [ConfigurasiUserController::class, 'reset_password'])->name('reset-password');
    });

});

require __DIR__.'/auth.php';
