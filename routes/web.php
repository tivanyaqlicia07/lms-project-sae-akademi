<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get ('/', function () {
    return view('welcome');
});

// Halaman login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard untuk masing-masing role
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Admin Dashboard";
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/editor/dashboard', function () {
        return "Editor Dashboard";
    })->name('editor.dashboard')->middleware('role:editor');

    Route::get('/fasilitator/dashboard', function () {
        return "Fasilitator Dashboard";
    })->name('fasilitator.dashboard')->middleware('role:fasilitator');

    Route::get('/mentor/dashboard', function () {
        return "Mentor Dashboard";
    })->name('mentor.dashboard')->middleware('role:mentor');
});