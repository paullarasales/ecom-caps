<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::get('/get-messages', [ChatController::class, 'getMessages']);
Route::get('/get-users', [ChatController::class, 'getUsers']);

Route::get('/admin/dashboard', [AdminController::class, 'chat'])->middleware(['auth', 'verified'])->name('admin.chat');


Route::get('/dashbaord', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/others', [AdminController::class, 'others'])->middleware(['auth', 'verified'])->name('others');
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware(['auth', 'verified'])->name('profile');


require __DIR__.'/auth.php';
