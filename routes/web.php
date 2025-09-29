<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('admin', [AdminController::class, 'index'])->name('admin.panel');
