<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (empty(\App\Models\User::first()))
        return view('auth.register'); // Vai para a view de registro caso não tenha úsuario cadastrado

    if (Auth::check())
        return view('index'); // View dashboard se tiver logado

    return view('auth.login'); // View login
});

Auth::routes();
