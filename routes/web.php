<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\SizeController;

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/employees', [\App\Http\Controllers\EmployeesController::class, 'index'])->name('employees')->middleware('auth');
    Route::get('/uniforms', [UniformController::class, 'index'])->name('uniforms.index')->middleware('auth');
    // Route::get('/uniform/create', [UniformController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/uniforms', [UniformController::class, 'store'])->name('uniforms.store')->middleware('auth');
    Route::get('/uniforms/{uniform}', [UniformController::class, 'show'])->name('uniforms.show')->middleware('auth');
    Route::get('/uniforms/{uniform}/edit', [UniformController::class, 'edit'])->name('uniforms.edit')->middleware('auth');
    Route::put('/uniforms/{uniform}', [UniformController::class, 'update'])->name('uniforms.update')->middleware('auth');
    Route::delete('/uniforms/{uniform}', [UniformController::class, 'destroy'])->name('uniforms.destroy')->middleware('auth');

    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index')->middleware('auth');
    // Route::get('/sizes/create', [UniformController::class, 'create'])->name('sizes.create')->middleware('auth');
    Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store')->middleware('auth');
    Route::get('/sizes/{size}', [SizeController::class, 'show'])->name('sizes.show')->middleware('auth');
    Route::get('/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit')->middleware('auth');
    Route::put('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update')->middleware('auth');
    Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy')->middleware('auth');
    
    // Route::view('about', 'about')->name('about');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    // Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
