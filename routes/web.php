<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PerfilController;

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

Route::get('/', [MainController::class, 'main'])->name('main');



Route::get('/login', [LoginController::class, 'login'])->name("login");
Route::post('/login', [LoginController::class, 'loginpost'])->name('loginpost');
Route::get('/logout', [LoginController::class, 'logout'])->middleware("auth")->name("logout");


Route::get('/cadastro', [CadastroController::class, 'showRegistrationForm'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'cadastro']);

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/usuarios', function () {return view('perfil');})->name('usuarios');
    Route::post('/users/{id}/update', [PerfilController::class, 'update'])->name('users.update');
    Route::post('/add-task', [TaskController::class, 'addTask'])->name('add.task');
    Route::get('/edit/{task}', 'TaskController@edit')->name('edit.task');
    Route::delete('/delete/{task}', [TaskController::class, 'destroy'])->name('delete.task');
    Route::post('/update-status/{taskId}', 'TaskController@updateStatus');
});
