<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

// Rute halaman utama langsung mengarah ke halaman prediksi harga rumah
Route::get('/', [PredictionController::class, 'index'])->name('prediction.index');
Route::post('/predict', [PredictionController::class, 'predict'])->name('prediction.predict');
