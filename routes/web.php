<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\User\AuthController as UserAuthController;
use App\Http\Controllers\Front\Agent\AuthController as AgentAuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Front\User\DashboardController as UserDahsboardController;
use App\Http\Controllers\Front\Agent\DashboardController as AgentDahsboardController;

// Front
Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('select/user', 'selectUser')->name('select.user');
    Route::get('user/dashboard', 'userDashboard')->name('user.dashboard');
    Route::get('agent/dashboard', 'agentDashboard')->name('agent.dashboard');
});

// User
Route::controller(UserAuthController::class)->prefix('user')->group(function () {
    Route::get('register', 'register')->name('user.register');
    Route::get('register/{token}', 'registerVerify')->name('user.register.verify');
    Route::post('register', 'registerSubmit')->name('user.register.submit');
    Route::get('login', 'login')->name('user.login');
    Route::post('login', 'loginSubmit')->name('user.login.submit');
    Route::post('logout', 'logout')->middleware('user.auth')->name('user.logout');
    Route::get('forget/password', 'forgetPassword')->name('user.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('user.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('user.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('user.reset.password.submit');
});

Route::controller(UserDahsboardController::class)->prefix('user')->middleware('user.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('user.edit.profile');
    Route::post('edit/profile/{user}', 'editProfileSubmit')->name('user.edit.profile.submit');
});

// Agent
Route::controller(AgentAuthController::class)->prefix('agent')->group(function () {
    Route::get('register', 'register')->name('agent.register');
    Route::get('register/{token}', 'registerVerify')->name('agent.register.verify');
    Route::post('register', 'registerSubmit')->name('agent.register.submit');
    Route::get('login', 'login')->name('agent.login');
    Route::post('login', 'loginSubmit')->name('agent.login.submit');
    Route::post('logout', 'logout')->middleware('agent.auth')->name('agent.logout');
    Route::get('forget/password', 'forgetPassword')->name('agent.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('agent.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('agent.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('agent.reset.password.submit');
});

Route::controller(AgentDahsboardController::class)->prefix('agent')->middleware('agent.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('agent.edit.profile');
    Route::post('edit/profile/{agent}', 'editProfileSubmit')->name('agent.edit.profile.submit');
});

// Admin
Route::get('admin', [AdminController::class, 'index'])->middleware('admin.auth')->name('admin.panel');

Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
    Route::get('login', 'login')->name('admin.login');
    Route::post('login', 'loginSubmit')->name('admin.login.submit');
    Route::post('logout', 'logout')->middleware('admin.auth')->name('admin.logout');
    Route::get('forget/password', 'forgetPassword')->name('admin.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('admin.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('admin.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('admin.reset.password.submit');
});
