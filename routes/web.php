<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerzuimController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/verzuim/upload', [VerzuimController::class, 'showUploadForm'])->name('verzuim.upload.form');
    Route::post('/verzuim/upload', [VerzuimController::class, 'upload'])->name('verzuim.upload');
    Route::post('/verzuim/gemiddelde', [VerzuimController::class, 'showGemiddelde'])->name('verzuim.gemiddelde');
});

require __DIR__.'/auth.php';
