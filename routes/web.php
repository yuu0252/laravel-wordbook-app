<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

require __DIR__ . '/auth.php';

Route::get('/books', [BookController::class, 'index'])->middleware(['auth', 'verified'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->middleware(['auth', 'verified'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->middleware(['auth', 'verified'])->name('books.store');
Route::get('/books/{book}', [BookController::class, 'show'])->middleware(['auth', 'verified'])->name('books.show');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->middleware(['auth', 'verified'])->name('books.edit');
Route::patch('/books/{book}', [BookController::class, 'update'])->middleware(['auth', 'verified'])->name('books.update');
