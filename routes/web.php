<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;


Route::controller(SiteController::class)->group(function() {
    Route::get('/secret', 'secret')->name('secret')->middleware('auth:sanctum');
    Route::get('/admin', 'admin')->name('admin')->middleware('auth:sanctum', 'abilities:admin');
    Route::get('/login', 'login')->name('login');
});
