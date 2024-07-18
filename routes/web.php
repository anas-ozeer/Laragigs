<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

// Get all the listings
Route::get('/', [ListingController::class, 'index'])->name('home');
// Create a listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
// Store a listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
// Edit a listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Update a listing
Route::patch('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
// Delete a listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');
// Manage a listing
Route::get('/listings/manage',[ListingController::class, 'manage'])->middleware('auth');

// Has to te at the end
// Get one specific listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// User Registration
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [UserController::class, 'store'])->middleware('guest');

// Log out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// User Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');




