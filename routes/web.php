<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');

Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');

Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::delete('tasks/{task}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');

