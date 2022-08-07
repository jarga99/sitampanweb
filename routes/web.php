<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TanamPajaleController;
use App\Http\Controllers\TanamHortiController;
use App\Http\Controllers\TanamPerkebunanController;
use App\Http\Controllers\PanenPajaleController;
use App\Http\Controllers\PanenHortiController;
use App\Http\Controllers\PanenPerkebunanController;
use App\Http\Controllers\UserPanenPajaleController;
use App\Http\Controllers\UserPanenHortiController;
use App\Http\Controllers\UserPanenPerkebunanController;
use App\Http\Controllers\UserTanamPajaleController;
use App\Http\Controllers\UserTanamHortiController;
use App\Http\Controllers\UserTanamPerkebunanController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/dashboard', function () {
//     return view('dashboard/counter',['title' => 'Home']);
// })->name('counter');

// Login
Route::GET('/', function () {
    return view('home');
});
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('counter');

    Route::group(['middleware' => 'superadmin'], function()
    {
         // User Config
         Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
         Route::resource('/user', UserController::class);
    });

    Route::group(['middleware' => 'superadmin','admin'], function()
    {
        // Profil Config
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

        Route::post('logout',[UserController::class, 'logout'])->name('logout');

        // Tanam Pajale
        Route::get('/tanam/tanam_pajale/data', [TanamPajaleController::class, 'data'])->name('tanam_pajale.data');
        Route::get('/tanam/tanam_pajale', [TanamPajaleController::class, 'index'])->name('tanam.index_pajale');
        Route::post('/tanam/tanam_pajale/create', [TanamPajaleController::class, 'store'])->name('tanam.create_pajale');
        Route::get('/tanam/tanam_pajale/edit', [TanamPajaleController::class, 'edit'])->name('tanam.edit_pajale');
        Route::put('/tanam/tanam_pajale/update/{id}', [TanamPajaleController::class, 'update'])->name('tanam.update_pajale');
        Route::delete('/tanam/tanam_pajale/delete/{id}', [TanamPajaleController::class, 'destroy'])->name('tanam.delete_pajale');
        Route::post('/tanam/tanam_pajale/delete-selected', [TanamPajaleController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_pajale/pdf', [TanamPajaleController::class, 'pdf_pajale'])->name('tanam.pdf_pajale');
        Route::get('/tanam/tanam_pajale/excel', [TanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
        // Tanam Horti
        Route::get('/tanam/tanam_horti/data', [TanamHortiController::class, 'data'])->name('tanam_horti.data');
        Route::get('/tanam/tanam_horti', [TanamHortiController::class, 'index'])->name('tanam.index_horti');
        Route::post('/tanam/tanam_horti/create', [TanamHortiController::class, 'store'])->name('tanam.create_horti');
        Route::get('/tanam/tanam_horti/edit', [TanamHortiController::class, 'edit'])->name('tanam.edit_horti');
        Route::put('/tanam/tanam_horti/update/{id}', [TanamHortiController::class, 'update'])->name('tanam.update_horti');
        Route::delete('/tanam/tanam_horti/delete/{id}', [TanamHortiController::class, 'destroy'])->name('tanam.delete_horti');
        Route::post('/tanam/tanam_horti/delete-selected', [TanamHortiController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_horti/pdf', [TanamHortiController::class, 'pdf_horti'])->name('tanam.pdf_horti');
        Route::get('/tanam/tanam_horti/excel', [TanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');
        // Tanam Perkebunan
        Route::get('/tanam/tanam_perkebunan/data', [TanamPerkebunanController::class, 'data'])->name('tanam_perkebunan.data');
        Route::get('/tanam/tanam_perkebunan', [TanamPerkebunanController::class, 'index'])->name('tanam.index_perkebunan');
        Route::post('/tanam/tanam_perkebunan/create', [TanamPerkebunanController::class, 'store'])->name('tanam.create_perkebunan');
        Route::put('/tanam/tanam_perkebunan/update/{id}', [TanamPerkebunanController::class, 'update'])->name('tanam.update_perkebunan');
        Route::get('/tanam/tanam_perkebunan/edit', [TanamPerkebunanController::class, 'edit'])->name('tanam.edit_perkebunan');
        Route::delete('/tanam/tanam_perkebunan/delete/{id}', [TanamPerkebunanController::class, 'destroy'])->name('tanam.delete_perkebunan');
        Route::post('/tanam/tanam_perkebunan/delete-selected', [TanamPerkebunanController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_perkebunan/pdf', [TanamPerkebunanController::class, 'pdf_perkebunan'])->name('tanam.pdf_perkebunan');
        Route::get('/tanam/tanam_perkebunan/excel', [TanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');

        // Panen Pajale
        Route::get('/panen/panen_pajale/data', [PanenPajaleController::class, 'data'])->name('panen_pajale.data');
        Route::get('/panen/panen_pajale', [PanenPajaleController::class, 'index'])->name('panen.index_pajale');
        Route::post('/panen/panen_pajale/create', [PanenPajaleController::class, 'store'])->name('panen.create_pajale');
        Route::get('/panen/panen_pajale/edit', [PanenPajaleController::class, 'edit'])->name('panen.edit_pajale');
        Route::put('/panen/panen_pajale/update/{id}', [PanenPajaleController::class, 'update'])->name('panen.update_pajale');
        Route::delete('/panen/panen_pajale/delete/{id}', [PanenPajaleController::class, 'destroy'])->name('panen.delete_pajale');
        Route::post('/panen/panen_pajale/delete-selected', [PanenPajaleController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_pajale/pdf', [PanenPajaleController::class, 'pdf_pajale'])->name('panen.pdf_pajale');
        Route::get('/panen/panen_pajale/excel', [PanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');
        // Panen Horti
        Route::get('/panen/panen_horti/data', [PanenHortiController::class, 'data'])->name('panen_horti.data');
        Route::get('/panen/panen_horti', [PanenHortiController::class, 'index'])->name('panen.index_horti');
        Route::post('/panen/panen_horti/create', [PanenHortiController::class, 'store'])->name('panen.create_horti');
        Route::get('/panen/panen_horti/edit', [PanenHortiController::class, 'edit'])->name('panen.edit_horti');
        Route::put('/panen/panen_horti/update/{id}', [PanenHortiController::class, 'update'])->name('panen.update_horti');
        Route::delete('/panen/panen_horti/delete/{id}', [PanenHortiController::class, 'destroy'])->name('panen.delete_horti');
        Route::post('/panen/panen_horti/delete-selected', [PanenHortiController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_horti/pdf', [PanenHortiController::class, 'pdf_horti'])->name('panen.pdf_horti');
        Route::get('/panen/panen_horti/excel', [PanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');
        // Panen Perkebunan
        Route::get('/panen/panen_perkebunan/data', [PanenPerkebunanController::class, 'data'])->name('panen_perkebunan.data');
        Route::get('/panen/panen_perkebunan', [PanenPerkebunanController::class, 'index'])->name('panen.index_perkebunan');
        Route::post('/panen/panen_perkebunan/create', [PanenPerkebunanController::class, 'store'])->name('panen.create_perkebunan');
        Route::get('/panen/panen_perkebunan/edit', [PanenPerkebunanController::class, 'edit'])->name('panen.edit_perkebunan');
        Route::put('/panen/panen_perkebunan/update/{id}', [PanenPerkebunanController::class, 'update'])->name('panen.update_perkebunan');
        Route::delete('/panen/panen_perkebunan/delete/{id}', [PanenPerkebunanController::class, 'destroy'])->name('panen.delete_perkebunan');
        Route::post('/panen/panen_perkebunan/delete-selected', [PanenPerkebunanController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_perkebunan/pdf', [PanenPerkebunanController::class, 'pdf_perkebunan'])->name('panen.pdf_perkebunan');
        Route::get('/panen/panen_perkebunan/excel', [PanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');
    });

    Route::get('/get-desa', [FilterController::class, 'getDesa'])->name('getdesa');

});

// ++++++++ For Front END / User +++++++++
// Tanam
// Pajale
Route::get('/user/tanam/user_tanam_pajale/data', [UserTanamPajaleController::class, 'data'])->name('user.user_tanam_pajale.data');
Route::get('/user/tanam/user_tanam_pajale', [UserTanamPajaleController::class, 'index'])->name('user.tanam.index_pajale');
Route::get('/user/tanam/user_tanam_pajale/excel', [UserTanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
Route::get('/user/tanam/user_tanam_pajale/pdf', [UserTanamPajaleController::class, 'pdf_pajale'])->name('tanam.pdf_pajale');
// Horti
Route::get('/user/tanam/user_tanam_horti/data', [UserTanamHortiController::class, 'data'])->name('user.user_tanam_horti.data');
Route::get('/user/tanam/user_tanam_horti', [UserTanamHortiController::class, 'index'])->name('user.tanam.index_horti');
Route::get('/user/tanam/user_tanam_horti/pdf', [UserTanamHortiController::class, 'pdf_horti'])->name('tanam.pdf_horti');
Route::get('/user/tanam/user_tanam_horti/excel', [UserTanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');

// Perkebunan
Route::get('/user/tanam/user_tanam_perkebunan/data', [UserTanamPerkebunanController::class, 'data'])->name('user.user_tanam_perkebunan.data');
Route::get('/user/tanam/user_tanam_perkebunan', [UserTanamPerkebunanController::class, 'index'])->name('user.tanam.index_perkebunan');
Route::get('/user/tanam/user_tanam_perkebunan/pdf', [UserTanamPerkebunanController::class, 'pdf_perkebunan'])->name('tanam.pdf_perkebunan');
Route::get('/user/tanam/user_tanam_perkebunan/excel', [UserTanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');
// Panen
// Pajale
Route::get('/user/panen/user_panen_pajale/data', [UserPanenPajaleController::class, 'data'])->name('user.user_panen_pajale.data');
Route::get('/user/panen/user_panen_pajale', [UserPanenPajaleController::class, 'index'])->name('user.panen.index_pajale');
Route::get('/user/panen/user_panen_pajale/pdf', [UserPanenPajaleController::class, 'pdf_pajale'])->name('panen.pdf_pajale');
Route::get('/user/panen/user_panen_pajale/excel', [UserPanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');

// Horti
Route::get('/user/panen/user_panen_horti/data', [UserPanenHortiController::class, 'data'])->name('user.user_panen_horti.data');
Route::get('/user/panen/user_panen_horti', [UserPanenHortiController::class, 'index'])->name('user.panen.index_horti');
Route::get('/user/panen/user_panen_horti/pdf', [UserPanenHortiController::class, 'pdf_horti'])->name('panen.pdf_horti');
Route::get('/user/panen/user_panen_horti/excel', [UserPanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');

// Perkebunan
Route::get('/user/panen/user_panen_perkebunan/data', [UserPanenPerkebunanController::class, 'data'])->name('user.user_panen_perkebunan.data');
Route::get('/user/panen/user_panen_perkebunan', [UserPanenPerkebunanController::class, 'index'])->name('user.panen.index_perkebunan');
Route::get('/user/panen/user_panen_perkebunan/pdf', [UserPanenPerkebunanController::class, 'pdf_perkebunan'])->name('panen.pdf_perkebunan');
Route::get('/user/panen/user_panen_perkebunan/excel', [UserPanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');
