<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TanamController;
use App\Http\Controllers\PanenController;
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

Route::get('/dashboard', function () {
    return view('dashboard/counter',['title' => 'Home']);
})->name('counter');

Route::GET('/', function (){
    return view('home');
});

// ======== All User Config========

// Register
Route::get('register',[UserController::class, 'register'])->name('register');
Route::post('register',[UserController::class, 'register_action'])->name('register.action');

// Login
Route::get('login',[UserController::class, 'login'])->name('login');
Route::post('login',[UserController::class, 'login_action'])->name('login.action');

// Profil Config
Route::get('user/profil',[UserController::class, 'profil'])->name('user.profil');
Route::post('user/profil',[UserController::class, 'profil_update'])->name('user.profil_update');

// Logout
Route::get('logout',[UserController::class, 'logout'])->name('logout');

// Create User
Route::get('user/index',[UserController::class, 'index'])->name('user.index');
Route::get('user',[UserController::class, 'create_user'])->name('login');
//  ======== End User Config=========

// +++++++++++ All Config Tanam +++++++++++++
// ++++ For Back END / Admin lvl 1 and 2 ++++
// Pajale
Route::get('/tanam/pajale', [TanamController::class, 'pajale_index'])->name('tanam.index_pajale');

// Horti
Route::get('/tanam/horti', [TanamController::class, 'horti_index'])->name('tanam.index_horti');

// Perkebunan
Route::get('/tanam/perkebunan', [TanamController::class, 'perkebunan_index'])->name('tanam.index_perkebunan');

// ++++++++ For Front END / User +++++++++
Route::get('/user/tanam/pajale', [TanamController::class, 'user_pajale_index'])->name('user.tanam.index_pajale');

// Horti
Route::get('/user/tanam/horti', [TanamController::class, 'user_horti_index'])->name('user.tanam.index_horti');

// Perkebunan
Route::get('/user/tanam/perkebunan', [TanamController::class, 'user_perkebunan_index'])->name('user.tanam.index_perkebunan');
// +++++++++++ End Config Tanam ++++++++++++

// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
// ++++ For Back END / Admin level 1 and 2 ++++
// Pajale
Route::get('/panen/pajale', [PanenController::class, 'pajale_index'])->name('panen.index_pajale');

// Horti
Route::get('/panen/horti/data', [PanenController::class, 'horti_data'])->name('horti.data');
Route::get('/panen/horti', [PanenController::class, 'horti_index'])->name('panen.index_horti');
Route::post('/panen/horti/create', [PanenController::class, 'horti_store'])->name('panen.create_horti');
Route::get('/panen/horti/edit', [PanenController::class, 'edit_horti'])->name('panen.edit_horti');
Route::put('/panen/horti/update/{id}', [PanenController::class, 'update_horti'])->name('panen.update_horti');
Route::delete('/panen/horti/delete/{id}', [PanenController::class, 'delete_horti'])->name('panen.delete_horti');
Route::post('/panen/horti/delete-selected', [PanenController::class, 'horti_deleteSelected'])->name('panen.delete_selected');
Route::get('/panen/horti/pdf', [PanenController::class, 'pdf_horti'])->name('panen.pdf_horti');
Route::get('/panen/horti/excel', [PanenController::class, 'excel_horti'])->name('panen.excel_horti');
// Route::resource('/panen', PanenController::class);

// Perkebunan
Route::get('/panen/perkebunan', [PanenController::class, 'perkebunan_index'])->name('panen.index_perkebunan');

// ++++++++ For Front END / User +++++++++
Route::get('/user/panen/pajale', [PanenController::class, 'user_pajale_index'])->name('user.panen.index_pajale');

// Horti
Route::get('/user/panen/horti', [PanenController::class, 'user_horti_index'])->name('user.panen.index_horti');

// Perkebunan
Route::get('/user/panen/perkebunan', [PanenController::class, 'user_perkebunan_index'])->name('user.panen.index_perkebunan');
// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
