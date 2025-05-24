<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerUser']);

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'loginUser']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tours', TourController::class);
    Route::delete('/tours/images/{image}', [TourController::class, 'destroyImage'])->name('tours.images.destroy');

    Route::middleware('role:admin,tour_planner')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/admin/users/create', [AuthController::class, 'registerUser'])->name('admin.users.store');
    });
});
