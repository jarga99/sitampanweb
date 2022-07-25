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


// ======== All User Config========

// Register
Route::get('register',[UserController::class, 'register'])->name('register');
Route::post('register',[UserController::class, 'register_action'])->name('register.action');

// Login
Route::get('login',[UserController::class, 'login'])->name('login');
Route::post('login',[UserController::class, 'login_action'])->name('login.action');

// Password Config
Route::get('password',[UserController::class, 'password'])->name('password');

// Route::METHOD('path',[CONTROLLER::class,'METHOD'])->name('FORM ACTION')
Route::post('password',[UserController::class, 'password_action'])->name('password.action');

// Logout
Route::get('logout',[UserController::class, 'logout'])->name('logout');

// Create User
Route::get('user',[UserController::class, 'create_user'])->name('login');
//  ======== End User Config=========

// +++++++++++ All Config Tanam ++++++++++++
// Pajale
Route::get('/tanam/pajale', [TanamController::class, 'pajale_index'])->name('tanam.index_pajale');

// Horti
Route::get('/tanam/horti', [TanamController::class, 'horti_index'])->name('tanam.index_horti');

// Perkebunan
Route::get('/tanam/perkebunan', [TanamController::class, 'perkebunan_index'])->name('tanam.index_perkebunan');

// +++++++++++ End Config Tanam ++++++++++++

// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
// Pajale
Route::get('/panen/pajale', [PanenController::class, 'pajale_index'])->name('panen.index_pajale');

// Horti
Route::get('/panen/horti', [PanenController::class, 'horti_index'])->name('panen.index_horti');

// Perkebunan
Route::get('/panen/perkebunan', [PanenController::class, 'perkebunan_index'])->name('panen.index_perkebunan');

// <<<<<<<<<<< All Config Panen >>>>>>>>>>>>
