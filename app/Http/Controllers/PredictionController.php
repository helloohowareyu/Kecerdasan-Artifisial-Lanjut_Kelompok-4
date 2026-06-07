<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    /**
     * Menampilkan halaman form prediksi harga rumah.
     */
    public function index()
    {
        return view('prediction');
    }

    /**
     * Mengirim data input user ke FastAPI dan mengembalikan hasil prediksi.
     */
    public function predict(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'LotArea'      => 'required|numeric|min:0',
            'GrLivArea'    => 'required|numeric|min:0',
            'FullBath'     => 'required|numeric|min:0',
            'BedroomAbvGr' => 'required|numeric|min:0',
            'KitchenAbvGr' => 'required|numeric|min:0',
            'TotRmsAbvGrd' => 'required|numeric|min:0',
            'GarageArea'   => 'required|numeric|min:0',
            'GarageCars'   => 'required|numeric|min:0',
            'PoolArea'     => 'required|numeric|min:0',
            'YearBuilt'    => 'required|numeric|min:1800|max:2030',
            'MSZoning'     => 'required|string|in:C (all),FV,RH,RL,RM',
        ]);

        try {
            // Simpan nilai asli dalam m² untuk ditampilkan kembali ke user
            $inputDisplay = $validated;

            // Konversi m² ke sqft untuk dikirim ke model (1 m² = 10.7639 sqft)
            $sqftPerM2 = 10.7639;
            $validated['LotArea']   = $validated['LotArea'] * $sqftPerM2;
            $validated['GrLivArea'] = $validated['GrLivArea'] * $sqftPerM2;
            $validated['GarageArea'] = $validated['GarageArea'] * $sqftPerM2;
            $validated['PoolArea']  = $validated['PoolArea'] * $sqftPerM2;

            // Kirim data (sudah dalam sqft) ke FastAPI endpoint /predict
            $response = Http::timeout(10)->post('http://127.0.0.1:8000/predict', $validated);

            if ($response->successful()) {
                $result = $response->json();
                return view('prediction', [
                    'predicted_price' => $result['predicted_price'],
                    'input'           => $inputDisplay,
                ]);
            }

            return back()->withInput()->withErrors([
                'api' => 'Gagal mendapatkan respons dari server prediksi. Status: ' . $response->status(),
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'api' => 'Tidak dapat terhubung ke server prediksi. Pastikan FastAPI server sedang berjalan. Error: ' . $e->getMessage(),
            ]);
        }
    }
}
