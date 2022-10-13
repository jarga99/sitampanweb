<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\UserController;
// tanam
use App\Http\Controllers\TanamPajaleController;
use App\Http\Controllers\TanamHortiController;
use App\Http\Controllers\TanamPerkebunanController;
// panen
use App\Http\Controllers\PanenPajaleController;
use App\Http\Controllers\PanenHortiController;
use App\Http\Controllers\PanenPerkebunanController;
// puso
use App\Http\Controllers\PusoPajaleController;
use App\Http\Controllers\PusoHortiController;
use App\Http\Controllers\PusoPerkebunanController;
// head tanam
use App\Http\Controllers\HeadTanamPajaleController;
use App\Http\Controllers\HeadTanamHortiController;
use App\Http\Controllers\HeadTanamPerkebunanController;
// head panen
use App\Http\Controllers\HeadPanenPajaleController;
use App\Http\Controllers\HeadPanenHortiController;
use App\Http\Controllers\HeadPanenPerkebunanController;
// head puso
use App\Http\Controllers\HeadPusoPajaleController;
use App\Http\Controllers\HeadPusoHortiController;
use App\Http\Controllers\HeadPusoPerkebunanController;
// admin tanam
use App\Http\Controllers\AdminTanamPajaleController;
use App\Http\Controllers\AdminTanamHortiController;
use App\Http\Controllers\AdminTanamPerkebunanController;
// admin panen
use App\Http\Controllers\AdminPanenPajaleController;
use App\Http\Controllers\AdminPanenHortiController;
use App\Http\Controllers\AdminPanenPerkebunanController;
// admin puso
use App\Http\Controllers\AdminPusoPajaleController;
use App\Http\Controllers\AdminPusoHortiController;
use App\Http\Controllers\AdminPusoPerkebunanController;
// user tanam
use App\Http\Controllers\UserTanamPajaleController;
use App\Http\Controllers\UserTanamHortiController;
use App\Http\Controllers\UserTanamPerkebunanController;
// user panen
use App\Http\Controllers\UserPanenPajaleController;
use App\Http\Controllers\UserPanenHortiController;
use App\Http\Controllers\UserPanenPerkebunanController;
// user puso
use App\Http\Controllers\UserPusoPajaleController;
use App\Http\Controllers\UserPusoHortiController;
use App\Http\Controllers\UserPusoPerkebunanController;

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

    Route::group(['middleware' => 'superadmin', 'pengawas'], function () {
        // User Config
        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);
    });
    Route::group(['middleware' => 'superadmin', 'admin', 'pengawas'], function () {
        // Profil Config
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

        Route::post('logout', [UserController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'superadmin'], function () {
        // Tanam Pajale
        Route::get('/tanam/tanam_pajale/data', [TanamPajaleController::class, 'data'])->name('tanam_pajale.data');
        Route::get('/tanam/tanam_pajale', [TanamPajaleController::class, 'index'])->name('tanam.index_pajale');
        Route::post('/tanam/tanam_pajale/create', [TanamPajaleController::class, 'store'])->name('tanam.create_pajale');
        Route::get('/tanam/tanam_pajale/edit', [TanamPajaleController::class, 'edit'])->name('tanam.edit_pajale');
        Route::put('/tanam/tanam_pajale/update/{id}', [TanamPajaleController::class, 'update'])->name('tanam.update_pajale');
        Route::delete('/tanam/tanam_pajale/delete/{id}', [TanamPajaleController::class, 'destroy'])->name('tanam.delete_pajale');
        Route::post('/tanam/tanam_pajale/delete-selected', [TanamPajaleController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_pajale/pdf', [TanamPajaleController::class, 'pdf_tanam_pajale'])->name('tanam.pdf_tanam_pajale');
        Route::get('/tanam/tanam_pajale/excel', [TanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
        // Tanam Horti
        Route::get('/tanam/tanam_horti/data', [TanamHortiController::class, 'data'])->name('tanam_horti.data');
        Route::get('/tanam/tanam_horti', [TanamHortiController::class, 'index'])->name('tanam.index_horti');
        Route::post('/tanam/tanam_horti/create', [TanamHortiController::class, 'store'])->name('tanam.create_horti');
        Route::get('/tanam/tanam_horti/edit', [TanamHortiController::class, 'edit'])->name('tanam.edit_horti');
        Route::put('/tanam/tanam_horti/update/{id}', [TanamHortiController::class, 'update'])->name('tanam.update_horti');
        Route::delete('/tanam/tanam_horti/delete/{id}', [TanamHortiController::class, 'destroy'])->name('tanam.delete_horti');
        Route::post('/tanam/tanam_horti/delete-selected', [TanamHortiController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_horti/pdf', [TanamHortiController::class, 'pdf_tanam_horti'])->name('tanam.pdf_tanam_horti');
        Route::get('/tanam/tanam_horti/excel', [TanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');
        // Tanam Perkebunan
        Route::get('/tanam/tanam_perkebunan/data', [TanamPerkebunanController::class, 'data'])->name('tanam_perkebunan.data');
        Route::get('/tanam/tanam_perkebunan', [TanamPerkebunanController::class, 'index'])->name('tanam.index_perkebunan');
        Route::post('/tanam/tanam_perkebunan/create', [TanamPerkebunanController::class, 'store'])->name('tanam.create_perkebunan');
        Route::put('/tanam/tanam_perkebunan/update/{id}', [TanamPerkebunanController::class, 'update'])->name('tanam.update_perkebunan');
        Route::get('/tanam/tanam_perkebunan/edit', [TanamPerkebunanController::class, 'edit'])->name('tanam.edit_perkebunan');
        Route::delete('/tanam/tanam_perkebunan/delete/{id}', [TanamPerkebunanController::class, 'destroy'])->name('tanam.delete_perkebunan');
        Route::post('/tanam/tanam_perkebunan/delete-selected', [TanamPerkebunanController::class, 'deleteSelected'])->name('tanam.delete_selected');
        Route::get('/tanam/tanam_perkebunan/pdf', [TanamPerkebunanController::class, 'pdf_tanam_perkebunan'])->name('tanam.pdf_tanam_perkebunan');
        Route::get('/tanam/tanam_perkebunan/excel', [TanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');

        // Panen Pajale
        Route::get('/panen/panen_pajale/data', [PanenPajaleController::class, 'data'])->name('panen_pajale.data');
        Route::get('/panen/panen_pajale', [PanenPajaleController::class, 'index'])->name('panen.index_pajale');
        Route::post('/panen/panen_pajale/create', [PanenPajaleController::class, 'store'])->name('panen.create_pajale');
        Route::get('/panen/panen_pajale/edit', [PanenPajaleController::class, 'edit'])->name('panen.edit_pajale');
        Route::put('/panen/panen_pajale/update/{id}', [PanenPajaleController::class, 'update'])->name('panen.update_pajale');
        Route::delete('/panen/panen_pajale/delete/{id}', [PanenPajaleController::class, 'destroy'])->name('panen.delete_pajale');
        Route::post('/panen/panen_pajale/delete-selected', [PanenPajaleController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_pajale/pdf', [PanenPajaleController::class, 'pdf_panen_pajale'])->name('panen.pdf_panen_pajale');
        Route::get('/panen/panen_pajale/excel', [PanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');
        // Panen Horti
        Route::get('/panen/panen_horti/data', [PanenHortiController::class, 'data'])->name('panen_horti.data');
        Route::get('/panen/panen_horti', [PanenHortiController::class, 'index'])->name('panen.index_horti');
        Route::post('/panen/panen_horti/create', [PanenHortiController::class, 'store'])->name('panen.create_horti');
        // Route::get('/panen/panen_horti/show/{id}', [PanenHortiController::class, 'show'])->name('panen.detail_horti');
        // Route::get('/panen/panen_horti/detail/{id}', [PanenHortiController::class, 'detail'])->name('panen.detail_horti');
        Route::get('/panen/panen_horti/edit', [PanenHortiController::class, 'edit'])->name('panen.edit_horti');
        Route::put('/panen/panen_horti/update/{id}', [PanenHortiController::class, 'update'])->name('panen.update_horti');
        Route::delete('/panen/panen_horti/delete/{id}', [PanenHortiController::class, 'destroy'])->name('panen.delete_horti');
        Route::post('/panen/panen_horti/delete-selected', [PanenHortiController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_horti/pdf', [PanenHortiController::class, 'pdf_panen_horti'])->name('panen.pdf_panen_horti');
        Route::get('/panen/panen_horti/excel', [PanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');
        // Panen Perkebunan
        Route::get('/panen/panen_perkebunan/data', [PanenPerkebunanController::class, 'data'])->name('panen_perkebunan.data');
        Route::get('/panen/panen_perkebunan', [PanenPerkebunanController::class, 'index'])->name('panen.index_perkebunan');
        Route::post('/panen/panen_perkebunan/create', [PanenPerkebunanController::class, 'store'])->name('panen.create_perkebunan');
        Route::get('/panen/panen_perkebunan/edit', [PanenPerkebunanController::class, 'edit'])->name('panen.edit_perkebunan');
        Route::put('/panen/panen_perkebunan/update/{id}', [PanenPerkebunanController::class, 'update'])->name('panen.update_perkebunan');
        Route::delete('/panen/panen_perkebunan/delete/{id}', [PanenPerkebunanController::class, 'destroy'])->name('panen.delete_perkebunan');
        Route::post('/panen/panen_perkebunan/delete-selected', [PanenPerkebunanController::class, 'deleteSelected'])->name('panen.delete_selected');
        Route::get('/panen/panen_perkebunan/pdf', [PanenPerkebunanController::class, 'pdf_panen_perkebunan'])->name('panen.pdf_panen_perkebunan');
        Route::get('/panen/panen_perkebunan/excel', [PanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');

        // Puso Pajale
        Route::get('/puso/puso_pajale/data', [PusoPajaleController::class, 'data'])->name('puso_pajale.data');
        Route::get('/puso/puso_pajale', [PusoPajaleController::class, 'index'])->name('puso.index_pajale');
        Route::post('/puso/puso_pajale/create', [PusoPajaleController::class, 'store'])->name('puso.create_pajale');
        Route::get('/puso/puso_pajale/edit', [PusoPajaleController::class, 'edit'])->name('puso.edit_pajale');
        Route::put('/puso/puso_pajale/update/{id}', [PusoPajaleController::class, 'update'])->name('puso.update_pajale');
        Route::delete('/puso/puso_pajale/delete/{id}', [PusoPajaleController::class, 'destroy'])->name('puso.delete_pajale');
        Route::post('/puso/puso_pajale/delete-selected', [PusoPajaleController::class, 'deleteSelected'])->name('puso.delete_selected');
        Route::get('/puso/puso_pajale/pdf', [PusoPajaleController::class, 'pdf_puso_pajale'])->name('puso.pdf_puso_pajale');
        Route::get('/puso/puso_pajale/excel', [PusoPajaleController::class, 'excel_pajale'])->name('puso.excel_pajale');
        // Puso Horti
        Route::get('/puso/puso_horti/data', [PusoHortiController::class, 'data'])->name('puso_horti.data');
        Route::get('/puso/puso_horti', [PusoHortiController::class, 'index'])->name('puso.index_horti');
        Route::post('/puso/puso_horti/create', [PusoHortiController::class, 'store'])->name('puso.create_horti');
        Route::get('/puso/puso_horti/edit', [PusoHortiController::class, 'edit'])->name('puso.edit_horti');
        Route::put('/puso/puso_horti/update/{id}', [PusoHortiController::class, 'update'])->name('puso.update_horti');
        Route::delete('/puso/puso_horti/delete/{id}', [PusoHortiController::class, 'destroy'])->name('puso.delete_horti');
        Route::post('/puso/puso_horti/delete-selected', [PusoHortiController::class, 'deleteSelected'])->name('puso.delete_selected');
        Route::get('/puso/puso_horti/pdf', [PusoHortiController::class, 'pdf_puso_horti'])->name('puso.pdf_puso_horti');
        Route::get('/puso/puso_horti/excel', [PusoHortiController::class, 'excel_horti'])->name('puso.excel_horti');
        // Puso Perkebunan
        Route::get('/puso/puso_perkebunan/data', [PusoPerkebunanController::class, 'data'])->name('puso_perkebunan.data');
        Route::get('/puso/puso_perkebunan', [PusoPerkebunanController::class, 'index'])->name('puso.index_perkebunan');
        Route::post('/puso/puso_perkebunan/create', [PusoPerkebunanController::class, 'store'])->name('puso.create_perkebunan');
        Route::get('/puso/puso_perkebunan/edit', [PusoPerkebunanController::class, 'edit'])->name('puso.edit_perkebunan');
        Route::put('/puso/puso_perkebunan/update/{id}', [PusoPerkebunanController::class, 'update'])->name('puso.update_perkebunan');
        Route::delete('/puso/puso_perkebunan/delete/{id}', [PusoPerkebunanController::class, 'destroy'])->name('puso.delete_perkebunan');
        Route::post('/puso/puso_perkebunan/delete-selected', [PusoPerkebunanController::class, 'deleteSelected'])->name('puso.delete_selected');
        Route::get('/puso/puso_perkebunan/pdf', [PusoPerkebunanController::class, 'pdf_puso_perkebunan'])->name('puso.pdf_puso_perkebunan');
        Route::get('/puso/puso_perkebunan/excel', [PusoPerkebunanController::class, 'excel_perkebunan'])->name('puso.excel_perkebunan');
    });

    Route::group(['middleware' => 'admin'], function () {
        // panen Pajale
        Route::get('/admin/panen/admin_panen_pajale/data', [AdminPanenPajaleController::class, 'data'])->name('admin.admin_panen_pajale.data');
        Route::get('/admin/panen/admin_panen_pajale', [AdminPanenPajaleController::class, 'index'])->name('admin.panen.index_pajale');
        Route::post('/admin/panen/admin_panen_pajale/create', [AdminPanenPajaleController::class, 'store'])->name('admin.panen.create_pajale');
        Route::get('/admin/panen/admin_panen_pajale/pdf', [AdminPanenPajaleController::class, 'pdf_panen_pajale'])->name('admin.panen.pdf_panen_pajale');
        Route::get('/admin/panen/admin_panen_pajale/excel', [AdminPanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');
        // panen Horti
        Route::get('/admin/panen/admin_panen_horti/data', [AdminPanenHortiController::class, 'data'])->name('admin.admin_panen_horti.data');
        Route::get('/admin/panen/admin_panen_horti', [AdminPanenHortiController::class, 'index'])->name('admin.panen.index_horti');
        Route::post('/admin/panen/admin_panen_horti/create', [AdminPanenHortiController::class, 'store'])->name('admin.panen.create_horti');
        Route::get('/admin/panen/admin_panen_horti/pdf', [AdminPanenHortiController::class, 'pdf_panen_horti'])->name('admin.panen.pdf_panen_horti');
        Route::get('/admin/panen/admin_panen_horti/excel', [AdminPanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');
        // panen Perkebunan
        Route::get('/admin/panen/admin_panen_perkebunan/data', [AdminPanenPerkebunanController::class, 'data'])->name('admin.admin_panen_perkebunan.data');
        Route::get('/admin/panen/admin_panen_perkebunan', [AdminPanenPerkebunanController::class, 'index'])->name('admin.panen.index_perkebunan');
        Route::post('/admin/panen/admin_panen_perkebunan/create', [AdminPanenPerkebunanController::class, 'store'])->name('admin.panen.create_perkebunan');
        Route::get('/admin/panen/admin_panen_perkebunan/pdf', [AdminPanenPerkebunanController::class, 'pdf_panen_perkebunan'])->name('admin.panen.pdf_panen_perkebunan');
        Route::get('/admin/panen/admin_panen_perkebunan/excel', [AdminPanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');

        // Puso
        // Pajale
        Route::get('/admin/puso/admin_puso_pajale/data', [AdminPusoPajaleController::class, 'data'])->name('admin.admin_puso_pajale.data');
        Route::get('/admin/puso/admin_puso_pajale', [AdminPusoPajaleController::class, 'index'])->name('admin.puso.index_pajale');
        Route::post('/admin/puso/admin_puso_pajale/create', [AdminPusoPajaleController::class, 'store'])->name('admin.puso.create_pajale');
        Route::get('/admin/puso/admin_puso_pajale/pdf', [AdminPusoPajaleController::class, 'pdf_puso_pajale'])->name('admin.puso.pdf_puso_pajale');
        Route::get('/admin/puso/admin_puso_pajale/excel', [AdminPusoPajaleController::class, 'excel_pajale'])->name('puso.excel_pajale');
        // Horti
        Route::get('/admin/puso/admin_puso_horti/data', [AdminPusoHortiController::class, 'data'])->name('admin.admin_puso_horti.data');
        Route::get('/admin/puso/admin_puso_horti', [AdminPusoHortiController::class, 'index'])->name('admin.puso.index_horti');
        Route::post('/admin/puso/admin_puso_horti/create', [AdminPusoHortiController::class, 'store'])->name('admin.puso.create_horti');
        Route::get('/admin/puso/admin_puso_horti/pdf', [AdminPusoHortiController::class, 'pdf_puso_horti'])->name('admin.puso.pdf_puso_horti');
        Route::get('/admin/puso/admin_puso_horti/excel', [AdminPusoHortiController::class, 'excel_horti'])->name('puso.excel_horti');
        // Perkebunan
        Route::get('/admin/puso/admin_puso_perkebunan/data', [AdminPusoPerkebunanController::class, 'data'])->name('admin.admin_puso_perkebunan.data');
        Route::get('/admin/puso/admin_puso_perkebunan', [AdminPusoPerkebunanController::class, 'index'])->name('admin.puso.index_perkebunan');
        Route::post('/admin/puso/admin_puso_perkebunan/create', [AdminPusoPerkebunanController::class, 'store'])->name('admin.puso.create_perkebunan');
        Route::get('/admin/puso/admin_puso_perkebunan/pdf', [AdminPusoPerkebunanController::class, 'pdf_puso_perkebunan'])->name('admin.puso.pdf_puso_perkebunan');
        Route::get('/admin/puso/admin_puso_perkebunan/excel', [AdminPusoPerkebunanController::class, 'excel_perkebunan'])->name('puso.excel_perkebunan');

        // Tanam
        // Tanam Pajale
        Route::get('/admin/tanam/admin_tanam_pajale/data', [AdminTanamPajaleController::class, 'data'])->name('admin.admin_tanam_pajale.data');
        Route::get('/admin/tanam/admin_tanam_pajale', [AdminTanamPajaleController::class, 'index'])->name('admin.tanam.index_pajale');
        Route::post('/admin/tanam/admin_tanam_pajale/create', [AdminTanamPajaleController::class, 'store'])->name('admin.tanam.create_pajale');
        Route::get('/admin/tanam/admin_tanam_pajale/pdf', [AdminTanamPajaleController::class, 'pdf_tanam_pajale'])->name('admin.tanam.pdf_tanam_pajale');
        Route::get('/admin/tanam/admin_tanam_pajale/excel', [AdminTanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
        // Tanam Horti
        Route::get('/admin/tanam/admin_tanam_horti/data', [AdminTanamHortiController::class, 'data'])->name('admin.admin_tanam_horti.data');
        Route::get('/admin/tanam/admin_tanam_horti', [AdminTanamHortiController::class, 'index'])->name('admin.tanam.index_horti');
        Route::post('/admin/tanam/admin_tanam_horti/create', [AdminTanamHortiController::class, 'store'])->name('admin.tanam.create_horti');
        Route::get('/admin/tanam/admin_tanam_horti/pdf', [AdminTanamHortiController::class, 'pdf_tanam_horti'])->name('admin.tanam.pdf_tanam_horti');
        Route::get('/admin/tanam/admin_tanam_horti/excel', [AdminTanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');
        // Tanam Perkebunan
        Route::get('/admin/tanam/admin_tanam_perkebunan/data', [AdminTanamPerkebunanController::class, 'data'])->name('admin.admin_tanam_perkebunan.data');
        Route::get('/admin/tanam/admin_tanam_perkebunan', [AdminTanamPerkebunanController::class, 'index'])->name('admin.tanam.index_perkebunan');
        Route::post('/admin/tanam/admin_tanam_perkebunan/create', [AdminTanamPerkebunanController::class, 'store'])->name('admin.tanam.create_perkebunan');
        Route::get('/admin/tanam/admin_tanam_perkebunan/pdf', [AdminTanamPerkebunanController::class, 'pdf_tanam_perkebunan'])->name('admin.tanam.pdf_tanam_perkebunan');
        Route::get('/admin/tanam/admin_tanam_perkebunan/excel', [AdminTanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');
    });
    Route::group(['middleware' => 'pengawas'], function () {
        // Tanam
        // Pajale
        Route::get('/head/tanam/head_tanam_pajale/data', [HeadTanamPajaleController::class, 'data'])->name('head.head_tanam_pajale.data');
        Route::get('/head/tanam/head_tanam_pajale', [HeadTanamPajaleController::class, 'index'])->name('head.tanam.index_pajale');
        Route::get('/head/tanam/head_tanam_pajale/pdf', [HeadTanamPajaleController::class, 'pdf_tanam_pajale'])->name('head.tanam.pdf_tanam_pajale');
        Route::get('/head/tanam/head_tanam_pajale/excel', [HeadTanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
        // Horti
        Route::get('/head/tanam/head_tanam_horti/data', [HeadTanamHortiController::class, 'data'])->name('head.head_tanam_horti.data');
        Route::get('/head/tanam/head_tanam_horti', [HeadTanamHortiController::class, 'index'])->name('head.tanam.index_horti');
        Route::get('/head/tanam/head_tanam_horti/pdf', [HeadTanamHortiController::class, 'pdf_tanam_horti'])->name('head.tanam.pdf_tanam_horti');
        Route::get('/head/tanam/head_tanam_horti/excel', [HeadTanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');

        // Perkebunan
        Route::get('/head/tanam/head_tanam_perkebunan/data', [HeadTanamPerkebunanController::class, 'data'])->name('head.head_tanam_perkebunan.data');
        Route::get('/head/tanam/head_tanam_perkebunan', [HeadTanamPerkebunanController::class, 'index'])->name('head.tanam.index_perkebunan');
        Route::get('/head/tanam/head_tanam_perkebunan/pdf', [HeadTanamPerkebunanController::class, 'pdf_tanam_perkebunan'])->name('head.tanam.pdf_tanam_perkebunan');
        Route::get('/head/tanam/head_tanam_perkebunan/excel', [HeadTanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');
        // Panen
        // Pajale
        Route::get('/head/panen/head_panen_pajale/data', [HeadPanenPajaleController::class, 'data'])->name('head.head_panen_pajale.data');
        Route::get('/head/panen/head_panen_pajale', [HeadPanenPajaleController::class, 'index'])->name('head.panen.index_pajale');
        Route::get('/head/panen/head_panen_pajale/pdf', [HeadPanenPajaleController::class, 'pdf_panen_pajale'])->name('head.panen.pdf_panen_pajale');
        Route::get('/head/panen/head_panen_pajale/excel', [HeadPanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');

        // Horti
        Route::get('/head/panen/head_panen_horti/data', [HeadPanenHortiController::class, 'data'])->name('head.head_panen_horti.data');
        Route::get('/head/panen/head_panen_horti', [HeadPanenHortiController::class, 'index'])->name('head.panen.index_horti');
        Route::get('/head/panen/head_panen_horti/pdf', [HeadPanenHortiController::class, 'pdf_panen_horti'])->name('head.panen.pdf_panen_horti');
        Route::get('/head/panen/head_panen_horti/excel', [HeadPanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');

        // Perkebunan
        Route::get('/head/panen/head_panen_perkebunan/data', [HeadPanenPerkebunanController::class, 'data'])->name('head.head_panen_perkebunan.data');
        Route::get('/head/panen/head_panen_perkebunan', [HeadPanenPerkebunanController::class, 'index'])->name('head.panen.index_perkebunan');
        Route::get('/head/panen/head_panen_perkebunan/pdf', [HeadPanenPerkebunanController::class, 'pdf_panen_perkebunan'])->name('head.panen.pdf_panen_perkebunan');
        Route::get('/head/panen/head_panen_perkebunan/excel', [HeadPanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');
        // Puso
        // Pajale
        Route::get('/head/puso/head_puso_pajale/data', [HeadPusoPajaleController::class, 'data'])->name('head.head_puso_pajale.data');
        Route::get('/head/puso/head_puso_pajale', [HeadPusoPajaleController::class, 'index'])->name('head.puso.index_pajale');
        Route::get('/head/puso/head_puso_pajale/pdf', [HeadPusoPajaleController::class, 'pdf_puso_pajale'])->name('head.puso.pdf_puso_pajale');
        Route::get('/head/puso/head_puso_pajale/excel', [HeadPusoPajaleController::class, 'excel_pajale'])->name('puso.excel_pajale');

        // Horti
        Route::get('/head/puso/head_puso_horti/data', [HeadPusoHortiController::class, 'data'])->name('head.head_puso_horti.data');
        Route::get('/head/puso/head_puso_horti', [HeadPusoHortiController::class, 'index'])->name('head.puso.index_horti');
        Route::get('/head/puso/head_puso_horti/pdf', [HeadPusoHortiController::class, 'pdf_puso_horti'])->name('head.puso.pdf_puso_horti');
        Route::get('/head/puso/head_puso_horti/excel', [HeadPusoHortiController::class, 'excel_horti'])->name('puso.excel_horti');

        // Perkebunan
        Route::get('/head/puso/head_puso_perkebunan/data', [HeadPusoPerkebunanController::class, 'data'])->name('head.head_puso_perkebunan.data');
        Route::get('/head/puso/head_puso_perkebunan', [HeadPusoPerkebunanController::class, 'index'])->name('head.puso.index_perkebunan');
        Route::get('/head/puso/head_puso_perkebunan/pdf', [HeadPusoPerkebunanController::class, 'pdf_puso_perkebunan'])->name('head.puso.pdf_puso_perkebunan');
        Route::get('/head/puso/head_puso_perkebunan/excel', [HeadPusoPerkebunanController::class, 'excel_perkebunan'])->name('puso.excel_perkebunan');
    });
    Route::get('/get-desa', [FilterController::class, 'getDesa'])->name('getdesa');
});
// ++++++++ For Front END / User +++++++++
// Tanam
// Pajale
Route::get('/user/tanam/user_tanam_pajale/data', [UserTanamPajaleController::class, 'data'])->name('user.user_tanam_pajale.data');
Route::get('/user/tanam/user_tanam_pajale', [UserTanamPajaleController::class, 'index'])->name('user.tanam.index_pajale');
Route::get('/user/tanam/user_tanam_pajale/pdf', [UserTanamPajaleController::class, 'pdf_tanam_pajale'])->name('user.tanam.pdf_tanam_pajale');
Route::get('/user/tanam/user_tanam_pajale/excel', [UserTanamPajaleController::class, 'excel_pajale'])->name('tanam.excel_pajale');
// Horti
Route::get('/user/tanam/user_tanam_horti/data', [UserTanamHortiController::class, 'data'])->name('user.user_tanam_horti.data');
Route::get('/user/tanam/user_tanam_horti', [UserTanamHortiController::class, 'index'])->name('user.tanam.index_horti');
Route::get('/user/tanam/user_tanam_horti/pdf', [UserTanamHortiController::class, 'pdf_tanam_horti'])->name('user.tanam.pdf_tanam_horti');
Route::get('/user/tanam/user_tanam_horti/excel', [UserTanamHortiController::class, 'excel_horti'])->name('tanam.excel_horti');
// Perkebunan
Route::get('/user/tanam/user_tanam_perkebunan/data', [UserTanamPerkebunanController::class, 'data'])->name('user.user_tanam_perkebunan.data');
Route::get('/user/tanam/user_tanam_perkebunan', [UserTanamPerkebunanController::class, 'index'])->name('user.tanam.index_perkebunan');
Route::get('/user/tanam/user_tanam_perkebunan/pdf', [UserTanamPerkebunanController::class, 'pdf_tanam_perkebunan'])->name('user.tanam.pdf_tanam_perkebunan');
Route::get('/user/tanam/user_tanam_perkebunan/excel', [UserTanamPerkebunanController::class, 'excel_perkebunan'])->name('tanam.excel_perkebunan');
// Panen
// Pajale
Route::get('/user/panen/user_panen_pajale/data', [UserPanenPajaleController::class, 'data'])->name('user.user_panen_pajale.data');
Route::get('/user/panen/user_panen_pajale', [UserPanenPajaleController::class, 'index'])->name('user.panen.index_pajale');
Route::get('/user/panen/user_panen_pajale/pdf', [UserPanenPajaleController::class, 'pdf_panen_pajale'])->name('user.panen.pdf_panen_pajale');
Route::get('/user/panen/user_panen_pajale/excel', [UserPanenPajaleController::class, 'excel_pajale'])->name('panen.excel_pajale');

// Horti
Route::get('/user/panen/user_panen_horti/data', [UserPanenHortiController::class, 'data'])->name('user.user_panen_horti.data');
Route::get('/user/panen/user_panen_horti', [UserPanenHortiController::class, 'index'])->name('user.panen.index_horti');
Route::get('/user/panen/user_panen_horti/pdf', [UserPanenHortiController::class, 'pdf_panen_horti'])->name('user.panen.pdf_panen_horti');
Route::get('/user/panen/user_panen_horti/excel', [UserPanenHortiController::class, 'excel_horti'])->name('panen.excel_horti');

// Perkebunan
Route::get('/user/panen/user_panen_perkebunan/data', [UserPanenPerkebunanController::class, 'data'])->name('user.user_panen_perkebunan.data');
Route::get('/user/panen/user_panen_perkebunan', [UserPanenPerkebunanController::class, 'index'])->name('user.panen.index_perkebunan');
Route::get('/user/panen/user_panen_perkebunan/pdf', [UserPanenPerkebunanController::class, 'pdf_panen_perkebunan'])->name('user.panen.pdf_panen_perkebunan');
Route::get('/user/panen/user_panen_perkebunan/excel', [UserPanenPerkebunanController::class, 'excel_perkebunan'])->name('panen.excel_perkebunan');
// Puso
// Pajale
Route::get('/user/puso/user_puso_pajale/data', [UserPusoPajaleController::class, 'data'])->name('user.user_puso_pajale.data');
Route::get('/user/puso/user_puso_pajale', [UserPusoPajaleController::class, 'index'])->name('user.puso.index_pajale');
Route::get('/user/puso/user_puso_pajale/pdf', [UserPusoPajaleController::class, 'pdf_puso_pajale'])->name('user.puso.pdf_puso_pajale');
Route::get('/user/puso/user_puso_pajale/excel', [UserPusoPajaleController::class, 'excel_pajale'])->name('puso.excel_pajale');

// Horti
Route::get('/user/puso/user_puso_horti/data', [UserPusoHortiController::class, 'data'])->name('user.user_puso_horti.data');
Route::get('/user/puso/user_puso_horti', [UserPusoHortiController::class, 'index'])->name('user.puso.index_horti');
Route::get('/user/puso/user_puso_horti/pdf', [UserPusoHortiController::class, 'pdf_puso_horti'])->name('user.puso.pdf_puso_horti');
Route::get('/user/puso/user_puso_horti/excel', [UserPusoHortiController::class, 'excel_horti'])->name('puso.excel_horti');

// Perkebunan
Route::get('/user/puso/user_puso_perkebunan/data', [UserPusoPerkebunanController::class, 'data'])->name('user.user_puso_perkebunan.data');
Route::get('/user/puso/user_puso_perkebunan', [UserPusoPerkebunanController::class, 'index'])->name('user.puso.index_perkebunan');
Route::get('/user/puso/user_puso_perkebunan/pdf', [UserPusoPerkebunanController::class, 'pdf_puso_perkebunan'])->name('user.puso.pdf_puso_perkebunan');
Route::get('/user/puso/user_puso_perkebunan/excel', [UserPusoPerkebunanController::class, 'excel_perkebunan'])->name('puso.excel_perkebunan');

