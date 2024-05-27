<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/register-employee', [\App\Http\Controllers\RegisterEmployeeController::class, 'index'])->name('register-employee')->middleware('auth');
    Route::get('/all-employees', [\App\Http\Controllers\AllEmployeesController::class, 'index'])->name('all-employees')->middleware('auth');
    Route::get('/add-uniform', [\App\Http\Controllers\AddUniformController::class, 'index'])->name('add-uniform')->middleware('auth');
    
    // Route::view('about', 'about')->name('about');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    // Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
