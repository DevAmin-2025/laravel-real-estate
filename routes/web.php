<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\PropertyTypeController as AdminPropertyTypeController;
use App\Http\Controllers\Admin\AmenityController as AdminAmenityController;
use App\Http\Controllers\Admin\DashboardController as AdminDahsboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Front\User\AuthController as UserAuthController;
use App\Http\Controllers\Front\Agent\AuthController as AgentAuthController;
use App\Http\Controllers\Front\User\DashboardController as UserDahsboardController;
use App\Http\Controllers\Front\Agent\DashboardController as AgentDahsboardController;
use App\Http\Controllers\Front\Agent\PaymentController as AgentPaymentController;
use App\Http\Controllers\Front\Agent\PropertyController as AgentPropertyController;

// Front
Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('select/user', 'selectUser')->name('select.user');
    Route::get('user/dashboard', 'userDashboard')->middleware('user.auth')->name('user.dashboard');
    Route::get('agent/dashboard', 'agentDashboard')->middleware('agent.auth')->name('agent.dashboard');
    Route::get('pricing', 'pricing')->name('pricing');
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
    Route::get('orders', 'orders')->name('agent.orders');
    Route::get('invoice/{order}', 'invoice')->name('agent.invoice');
    Route::get('plan', 'plan')->name('agent.plan');
});

Route::controller(AgentPaymentController::class)->prefix('agent')->middleware('agent.auth')->group(function () {
    Route::post('payment/send/{plan}', 'send')->name('agent.payment.send');
    Route::get('payment/verify', 'verify')->name('agent.payment.verify');
});

Route::controller(AgentPropertyController::class)->middleware('agent.auth')->prefix('agent')->group(function () {
    Route::get('photo-gallery/{property}', 'photoGallery')->name('agent.photo.gallery');
    Route::post('photo-gallery/{property}', 'photoGallerySubmit')->name('agent.photo.gallery.submit');
    Route::delete('photo-gallery/{propertyPhoto}', 'photoGalleryDestroy')->name('agent.photo.gallery.destroy');
    Route::get('video-gallery/{property}', 'videoGallery')->name('agent.video.gallery');
    Route::post('video-gallery/{property}', 'videoGallerySubmit')->name('agent.video.gallery.submit');
    Route::delete('video-gallery/{propertyVideo}', 'videoGalleryDestroy')->name('agent.video.gallery.destroy');
});
Route::resource('agent/properties', AgentPropertyController::class)->middleware('agent.auth')->names('agent.properties');

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

Route::controller(AdminDahsboardController::class)->prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('admin.edit.profile');
    Route::post('edit/profile/{admin}', 'editProfileSubmit')->name('admin.edit.profile.submit');
});

Route::resource('admin/plans', AdminPlanController::class)->middleware('admin.auth')->except('show')->names('admin.plans');
Route::resource('admin/locations', AdminLocationController::class)->middleware('admin.auth')->except('show')->names('admin.locations');
Route::resource('admin/property-types', AdminPropertyTypeController::class)->middleware('admin.auth')->except('show')->names('admin.property.types');
Route::resource('admin/amenities', AdminAmenityController::class)->middleware('admin.auth')->except('show')->names('admin.amenities');
Route::resource('admin/users', AdminUserController::class)->middleware('admin.auth')->except('show')->names('admin.users');
Route::resource('admin/agents', AdminAgentController::class)->middleware('admin.auth')->names('admin.agents');

Route::controller(AdminOrderController::class)->prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('orders', 'index')->name('admin.orders');
    Route::get('invoice/{order}', 'invoice')->name('admin.invoice');
});
