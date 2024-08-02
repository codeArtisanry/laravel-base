<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return
        Route::view('/register', 'auth.register');
});

Route::view('/register', 'auth.register');
Route::view('/login', 'auth.login');
