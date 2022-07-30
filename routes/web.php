<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TanamPajaleController;
use App\Http\Controllers\TanamHortiController;
use App\Http\Controllers\TanamPerkebunanController;
use App\Http\Controllers\PanenPajaleController;
use App\Http\Controllers\PanenHortiController;
use App\Http\Controllers\PanenPerkebunanController;
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
Route::get('/tanam/pajale', [TanamPajaleController::class, 'index'])->name('tanam.index_pajale');

// Horti
Route::get('/tanam/horti', [TanamHortiController::class, 'index'])->name('tanam.index_horti');

// Perkebunan
Route::get('/tanam/perkebunan', [TanamPerkebunanController::class, 'index'])->name('tanam.index_perkebunan');

// ++++++++ For Front END / User +++++++++
Route::get('/user/tanam/pajale', [TanamPajaleController::class, 'user_index'])->name('user.tanam.index_pajale');

// Horti
Route::get('/user/tanam/horti', [TanamHortiController::class, 'user_index'])->name('user.tanam.index_horti');

// Perkebunan
Route::get('/user/tanam/perkebunan', [TanamPerkebunanController::class, 'user_index'])->name('user.tanam.index_perkebunan');
// +++++++++++ End Config Tanam ++++++++++++

// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
// ++++ For Back END / Admin level 1 and 2 ++++
// Pajale
Route::get('/panen/pajale', [PanenPajaleController::class, 'index'])->name('panen.index_pajale');

// Horti
Route::resource('/panen/horti', PanenHortiController::class);
Route::get('/panen/horti', [PanenHortiController::class, 'index'])->name('panen.index_horti');
Route::get('/panen/horti/data', [PanenHortiController::class, 'horti_data'])->name('horti.data');
Route::post('/panen/horti/delete-selected', [PanenHortiController::class, 'horti_deleteSelected'])->name('panen.delete_selected');

// Perkebunan
Route::get('/panen/perkebunan', [PanenPerkebunanController::class, 'index'])->name('panen.index_perkebunan');

// ++++++++ For Front END / User +++++++++
Route::get('/user/panen/pajale', [PanenPajaleController::class, 'user_index'])->name('user.panen.index_pajale');

// Horti
Route::get('/user/panen/horti', [PanenHortiController::class, 'user_index'])->name('user.panen.index_horti');

// Perkebunan
Route::get('/user/panen/perkebunan', [PanenPerkebunanController::class, 'user_index'])->name('user.panen.index_perkebunan');
// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
