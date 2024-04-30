<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Mail;
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

// Import the Auth class
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
//Criar a Rota para Tarefa através do TarefaController
Route::resource('tarefa', TarefaController::class)->middleware('verified');
Route::get('/mensagem-teste', function () {
    return new MensagemTesteMail();
    /* Mail::to('applefactstech@gmail.com')->send(new MensagemTesteMail());
    return 'E-mail enviado com sucesso'; */
});
