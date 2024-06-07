<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WithdrawController;

Auth::routes();

Route::get('/home', [WithdrawController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [WithdrawController::class, 'index'])->name('home')->middleware('auth');



Route::middleware('auth')->group(function () {
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

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index')->middleware('auth');
    // Route::get('/employees/create', [UniformController::class, 'create'])->name('employees.create')->middleware('auth');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store')->middleware('auth');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show')->middleware('auth');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit')->middleware('auth');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update')->middleware('auth');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy')->middleware('auth');

    Route::get('/withdraws', [WithdrawController::class, 'index'])->name('withdraws.index')->middleware('auth');
    // Route::get('/withdraws/create', [UniformController::class, 'create'])->name('withdraws.create')->middleware('auth');
    Route::post('/withdraws', [WithdrawController::class, 'store'])->name('withdraws.store')->middleware('auth');
    Route::get('/withdraws/{withdraw}', [WithdrawController::class, 'show'])->name('withdraws.show')->middleware('auth');
    Route::get('/withdraws/{withdraw}/edit', [WithdrawController::class, 'edit'])->name('withdraws.edit')->middleware('auth');
    Route::put('/withdraws/{withdraw}', [WithdrawController::class, 'update'])->name('withdraws.update')->middleware('auth');
    Route::delete('/withdraws/{withdraw}', [WithdrawController::class, 'destroy'])->name('withdraws.destroy')->middleware('auth');
    
    // Route::view('about', 'about')->name('about');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    // Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
