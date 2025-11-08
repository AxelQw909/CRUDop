<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('register');
});

use Illuminate\Http\Request;

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|min:2',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed'
    ]);
    return "Регистрация успешна!";
})->name('register.submit');
