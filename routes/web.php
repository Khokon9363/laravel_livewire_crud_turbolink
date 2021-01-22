<?php

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
    return view('welcome');
});


// they are LiveWire omponents .. akhane laravel er sob sytex e use kora jabe like name, middleware, namespace etc
Route::get('/login', '\App\Http\Livewire\Login');
Route::get('/register', '\App\Http\Livewire\Register');