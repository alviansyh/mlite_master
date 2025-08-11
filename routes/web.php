<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/app/login', 301)->name('login');
Route::redirect('/adm/login', '/app/login', 301);
Route::redirect('/wrh/login', '/app/login', 301);
Route::redirect('/mar/login', '/app/login', 301);