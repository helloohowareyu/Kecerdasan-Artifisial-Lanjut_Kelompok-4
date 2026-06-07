<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman prediksi harga rumah
Route::get('/predict', [PredictionController::class, 'index'])->name('prediction.index');
Route::post('/predict', [PredictionController::class, 'predict'])->name('prediction.predict');
