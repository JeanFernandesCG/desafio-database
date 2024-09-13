<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('telaInicial');
});

Route::get('/relatorio1', function () {
    return view('relatorio1');
});

Route::get('/relatorio2', function () {
    return view('relatorio2');
});

Route::get('/relatorio3', function () {
    return view('relatorio3');
});

Route::get('/relatorio4', function () {
    return view('relatorio4');
});

Route::get('/relatorio5', function () {
    return view('relatorio5');
});