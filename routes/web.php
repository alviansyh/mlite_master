<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/app', 301);
Route::redirect('/adm/login', '/app', 301);
Route::redirect('/mar/login', '/app', 301);