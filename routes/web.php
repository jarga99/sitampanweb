<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TanamPajaleController;
use App\Http\Controllers\TanamHortiController;
use App\Http\Controllers\TanamPerkebunanController;
use App\Http\Controllers\PanenPajaleController;
use App\Http\Controllers\PanenHortiController;
use App\Http\Controllers\PanenPerkebunanController;
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

    // Route::group(['middleware' => 'level:1'], function()
    // {
         // User Config
         Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
         Route::resource('/user', UserController::class);
    // });

    // Route::group(['middleware' => 'level:1,2'], function()
    // {
        // Profil Config
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

        Route::get('logout',[UserController::class, 'logout'])->name('logout');

        // Tanam Pajale
        Route::get('/tanam/pajale/data', [TanamPajaleController::class, 'data'])->name('pajale.data');
        Route::get('/tanam/pajale', [TanamPajaleController::class, 'index'])->name('tanam.index_pajale');
        Route::post('/tanam/pajale/create', [TanamPajaleController::class, 'store'])->name('tanam.create_pajale');
        Route::get('/tanam/pajale/edit', [TanamPajaleController::class, 'edit'])->name('tanam.edit_pajale');
        Route::put('/tanam/pajale/update/{id}', [TanamPajaleController::class, 'update'])->name('tanam.update_pajale');
        Route::delete('/tanam/pajale/delete/{id}', [TanamPajaleController::class, 'destroy'])->name('tanam.delete_pajale');
        Route::post('/tanam/pajale/delete-selected', [TanamPajaleController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/pajale/pdf', [TanamPajaleController::class, 'pdf_pajale'])->name('tanam.pdf_pajale');
        Route::get('/tanam/pajale/excel', [TanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
        // Tanam Horti
        Route::get('/tanam/horti/data', [TanamHortiController::class, 'data'])->name('horti.data');
        Route::get('/tanam/horti', [TanamHortiController::class, 'index'])->name('tanam.index_horti');
        Route::post('/tanam/horti/create', [TanamHortiController::class, 'store'])->name('tanam.create_horti');
        Route::get('/tanam/horti/edit', [TanamHortiController::class, 'edit'])->name('tanam.edit_horti');
        Route::put('/tanam/horti/update/{id}', [TanamHortiController::class, 'update'])->name('tanam.update_horti');
        Route::delete('/tanam/horti/delete/{id}', [TanamHortiController::class, 'destroy'])->name('tanam.delete_horti');
        Route::post('/tanam/horti/delete-selected', [TanamHortiController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/horti/pdf', [TanamHortiController::class, 'pdf_horti'])->name('tanam.pdf_horti');
        Route::get('/tanam/horti/excel', [TanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');
        // Tanam Perkebunan
        Route::get('/tanam/perkebunan/data', [TanamPajaleController::class, 'data'])->name('perkebunan.data');
        Route::get('/tanam/perkebunan', [TanamPerkebunanController::class, 'index'])->name('tanam.index_perkebunan');
        Route::post('/tanam/perkebunan/create', [TanamPajaleController::class, 'store'])->name('tanam.create_perkebunan');
        Route::get('/tanam/perkebunan/edit', [TanamPajaleController::class, 'edit'])->name('tanam.edit_perkebunan');
        Route::put('/tanam/perkebunan/update/{id}', [TanamPajaleController::class, 'update'])->name('tanam.update_perkebunan');
        Route::delete('/tanam/perkebunan/delete/{id}', [TanamPajaleController::class, 'destroy'])->name('tanam.delete_perkebunan');
        Route::post('/tanam/perkebunan/delete-selected', [TanamPajaleController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/perkebunan/pdf', [TanamHPajaleontroller::class, 'pdf_perkebunan'])->name('tanam.pdf_perkebunan');
        Route::get('/tanam/perkebunan/excel', [TanamPajaleController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');

        // Panen Pajale
        Route::get('/panen/pajale/data', [PanenPajaleController::class, 'data'])->name('pajale.data');
        Route::get('/panen/pajale', [PanenPajaleController::class, 'index'])->name('panen.index_pajale');
        Route::post('/panen/pajale/create', [PanenPajaleController::class, 'store'])->name('panen.create_pajale');
        Route::get('/panen/pajale/edit', [PanenPajaleController::class, 'edit'])->name('panen.edit_pajale');
        Route::put('/panen/pajale/update/{id}', [PanenPajaleController::class, 'update'])->name('panen.update_pajale');
        Route::delete('/panen/pajale/delete/{id}', [PanenPajaleController::class, 'destroy'])->name('panen.delete_pajale');
        Route::post('/panen/pajale/delete-selected', [PanenPajaleController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/pajale/pdf', [PanenPajaleController::class, 'pdf_pajale'])->name('panen.pdf_pajale');
        Route::get('/panen/pajale/excel', [PanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');
        // Panen Horti
        Route::get('/panen/horti/data', [PanenHortiController::class, 'data'])->name('horti.data');
        Route::get('/panen/horti', [PanenHortiController::class, 'index'])->name('panen.index_horti');
        Route::post('/panen/horti/create', [PanenHortiController::class, 'store'])->name('panen.create_horti');
        Route::get('/panen/horti/edit', [PanenHortiController::class, 'edit'])->name('panen.edit_horti');
        Route::put('/panen/horti/update/{id}', [PanenHortiController::class, 'update'])->name('panen.update_horti');
        Route::delete('/panen/horti/delete/{id}', [PanenHortiController::class, 'destroy'])->name('panen.delete_horti');
        Route::post('/panen/horti/delete-selected', [PanenHortiController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/horti/pdf', [PanenHortiController::class, 'pdf_horti'])->name('panen.pdf_horti');
        Route::get('/panen/horti/excel', [PanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');
        // Panen Perkebunan
        Route::get('/panen/perkebunan/data', [PanenPerkebunanController::class, 'data'])->name('perkebunan.data');
        Route::get('/panen/perkebunan', [PanenPerkebunanController::class, 'index'])->name('panen.index_perkebunan');
        Route::post('/panen/perkebunan/create', [PanenPerkebunanController::class, 'store'])->name('panen.create_perkebunan');
        Route::get('/panen/perkebunan/edit', [PanenPerkebunanController::class, 'edit'])->name('panen.edit_perkebunan');
        Route::put('/panen/perkebunan/update/{id}', [PanenPerkebunanController::class, 'update'])->name('panen.update_perkebunan');
        Route::delete('/panen/perkebunan/delete/{id}', [PanenPerkebunanController::class, 'destroy'])->name('panen.delete_perkebunan');
        Route::post('/panen/perkebunan/delete-selected', [PanenPerkebunanController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/perkebunan/pdf', [PanenPerkebunanController::class, 'pdf_perkebunan'])->name('panen.pdf_perkebunan');
        Route::get('/panen/perkebunan/excel', [PanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');
    // });

});

// ++++++++ For Front END / User +++++++++
// Tanam
// Pajale
Route::get('/tanam/pajale/data', [TanamPajaleController::class, 'data'])->name('pajale.data');
Route::get('/user/tanam/pajale', [TanamPajaleController::class, 'user_index'])->name('user.tanam.index_pajale');
Route::get('/tanam/pajale/pdf', [TanamPajaleController::class, 'pdf_pajale'])->name('tanam.pdf_pajale');
Route::get('/tanam/pajale/excel', [TanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
// Horti
Route::get('/tanam/horti/data', [TanamHortiController::class, 'data'])->name('horti.data');
Route::get('/user/tanam/horti', [TanamHortiController::class, 'user_index'])->name('user.tanam.index_horti');
Route::get('/tanam/horti/pdf', [TanamHortiController::class, 'pdf_horti'])->name('tanam.pdf_horti');
Route::get('/tanam/horti/excel', [TanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');

// Perkebunan
Route::get('/tanam/perkebunan/data', [TanamPajaleController::class, 'data'])->name('perkebunan.data');
Route::get('/user/tanam/perkebunan', [TanamPerkebunanController::class, 'user_index'])->name('user.tanam.index_perkebunan');
Route::get('/tanam/perkebunan/pdf', [TanamHPajaleontroller::class, 'pdf_perkebunan'])->name('tanam.pdf_perkebunan');
Route::get('/tanam/perkebunan/excel', [TanamPajaleController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');
// Panen
// Pajale
Route::get('/user/panen/pajale/data', [PanenPajaleController::class, 'data'])->name('user.pajale.data');
Route::get('/user/panen/pajale', [PanenPajaleController::class, 'user_index'])->name('user.panen.index_pajale');
Route::get('/user/panen/pajale/pdf', [PanenPajaleController::class, 'pdf_pajale'])->name('user.panen.pdf_pajale');
Route::get('/user/panen/pajale/excel', [PanenPajaleController::class, 'excel_pajale'])->name('user.panen.excel_pajale');

// Horti
Route::get('/user/panen/horti/data', [PanenHortiController::class, 'data'])->name('user.horti.data');
Route::get('/user/panen/horti', [PanenHortiController::class, 'user_index'])->name('user.panen.index_horti');
Route::get('/user/panen/horti/pdf', [PanenHortiController::class, 'pdf_horti'])->name('user.panen.pdf_horti');
Route::get('/user/panen/horti/excel', [PanenHortiController::class, 'excel_horti'])->name('user.panen.excel_horti');

// Perkebunan
Route::get('/user/panen/perkebunan/data', [PanenPerkebunanController::class, 'data'])->name('user.perkebunan.data');
Route::get('/user/panen/perkebunan', [PanenPerkebunanController::class, 'user_index'])->name('user.panen.index_perkebunan');
Route::get('/user/panen/perkebunan/pdf', [PanenPerkebunanController::class, 'pdf_perkebunan'])->name('user.panen.pdf_perkebunan');
Route::get('/user/panen/perkebunan/excel', [PanenPerkebunanController::class, 'excel_perkebunan'])->name('user.panen.excel_perkebunan');
