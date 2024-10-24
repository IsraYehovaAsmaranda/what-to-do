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

Route::get('/', ['App\Http\Controllers\homeController', 'index'])->name('home');

Route::post('/rate', ['App\Http\Controllers\homeController', 'giveRating']);

Route::delete('/ideas/{id}', ['App\Http\Controllers\homeController', 'deleteIdea']);

Route::get('/login', ['App\Http\Controllers\loginController', 'index']);

Route::post('/login', ['App\Http\Controllers\loginController', 'login']);

Route::get('/register', ['App\Http\Controllers\registerController', 'index']);

Route::post('/register', ['App\Http\Controllers\registerController', 'registerNewAccount']);

Route::get('/postidea', ['App\Http\Controllers\newIdeaController', 'index']);

Route::post('/postidea', ['App\Http\Controllers\newIdeaController', 'store']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logout successful.');
});
