<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Price Predictor - AI Powered</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary: #0a0e1a;
            --bg-card: rgba(15, 23, 42, 0.8);
            --bg-input: rgba(30, 41, 59, 0.6);
            --border: rgba(99, 102, 241, 0.2);
            --border-focus: rgba(99, 102, 241, 0.6);
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-label: #cbd5e1;
            --accent: #818cf8;
            --accent-glow: rgba(99, 102, 241, 0.3);
            --success: #34d399;
            --error: #f87171;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.06) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(79, 70, 229, 0.04) 0%, transparent 50%);
            animation: bgFloat 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, -2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-0.5deg); }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.8s ease;
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.25);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.8rem;
            color: var(--accent);
            font-weight: 500;
            margin-bottom: 1.2rem;
            letter-spacing: 0.05em;
        }

        .header-badge .dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 0.6rem;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Card */
        .card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 1.2rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.6s ease;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title .icon {
            width: 32px;
            height: 32px;
            background: var(--gradient-1);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: white;
            font-weight: 700;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.2rem;
        }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.6rem; }
        }

        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group.full-width { grid-column: 1 / -1; }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-label);
            letter-spacing: 0.02em;
        }

        .form-group label .hint {
            color: var(--text-secondary);
            font-weight: 400;
            font-size: 0.7rem;
        }

        .form-group input,
        .form-group select {
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 0.6rem;
            padding: 0.7rem 0.9rem;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            outline: none;
            width: 100%;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-group input::placeholder { color: var(--text-secondary); opacity: 0.6; }

        .form-group select option {
            background: #1e293b;
            color: var(--text-primary);
        }

        /* Invalid input styling (red border on empty required fields) */
        .form-group input.input-error,
        .form-group select.input-error {
            border-color: var(--error);
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.2);
            background: rgba(248, 113, 113, 0.05);
        }

        /* Submit Button */
        .btn-predict {
            width: 100%;
            margin-top: 1.5rem;
            padding: 0.9rem;
            background: var(--gradient-2);
            border: none;
            border-radius: 0.7rem;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
            position: relative;
            overflow: hidden;
        }

        .btn-predict:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
        }

        .btn-predict:active { transform: translateY(0); }

        /* New Prediction Button */
        .btn-new-predict {
            display: block;
            width: 100%;
            margin-top: 1.2rem;
            padding: 0.85rem;
            background: transparent;
            border: 1px solid var(--border-focus);
            border-radius: 0.7rem;
            color: var(--accent);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
        }

        .btn-new-predict:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
        }

        /* Result Card */
        .result-card {
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 1.2rem;
            padding: 2rem;
            text-align: center;
            animation: scaleIn 0.5s ease;
        }

        .result-label {
            font-size: 0.85rem;
            color: var(--success);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .result-price {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #34d399, #6ee7b7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .result-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.8rem;
            margin-top: 1.5rem;
        }

        .detail-item {
            background: rgba(15, 23, 42, 0.5);
            border-radius: 0.6rem;
            padding: 0.7rem;
            text-align: center;
        }

        .detail-item .detail-label {
            font-size: 0.65rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-item .detail-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 0.15rem;
        }

        /* Error Alert */
        .error-alert {
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.3);
            border-radius: 0.7rem;
            padding: 1rem 1.2rem;
            color: var(--error);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.4s ease;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-badge">
                <span class="dot"></span>
                AI-Powered Prediction
            </div>
            <h1>House Price Predictor</h1>
            <p>Masukkan spesifikasi rumah Anda untuk mendapatkan estimasi harga berdasarkan model Machine Learning.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Result Card (shown after prediction) -->
        @if (isset($predicted_price))
            @php
                $zonasiLabels = [
                    'RL' => 'Perumahan Kepadatan Rendah',
                    'RM' => 'Perumahan Kepadatan Sedang',
                    'RH' => 'Perumahan Kepadatan Tinggi',
                    'FV' => 'Desa Terapung',
                    'C (all)' => 'Komersial',
                ];
            @endphp
            <div class="result-card">
                <div class="result-label">Estimasi Harga Rumah</div>
                <div class="result-price">${{ number_format($predicted_price, 2) }}</div>
                <p style="color: var(--text-secondary); font-size: 0.85rem;">
                    Berdasarkan model Linear Regression (R² = 0.73)
                </p>
                <div class="result-details">
                    <div class="detail-item">
                        <div class="detail-label">Luas Tanah</div>
                        <div class="detail-value">{{ number_format($input['LotArea'], 1) }} m²</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Luas Bangunan</div>
                        <div class="detail-value">{{ number_format($input['GrLivArea'], 1) }} m²</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kamar Tidur</div>
                        <div class="detail-value">{{ (int) $input['BedroomAbvGr'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kamar Mandi</div>
                        <div class="detail-value">{{ (int) $input['FullBath'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tahun Dibangun</div>
                        <div class="detail-value">{{ (int) $input['YearBuilt'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Zonasi</div>
                        <div class="detail-value">{{ $zonasiLabels[$input['MSZoning']] ?? $input['MSZoning'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Tombol untuk memulai prediksi baru -->
            <a href="{{ route('prediction.index') }}" class="btn-new-predict" id="btn-new-predict">
                Prediksi Baru
            </a>
        @endif

        <!-- Input Form -->
        <form action="{{ route('prediction.predict') }}" method="POST" id="prediction-form" novalidate>
            @csrf

            <!-- Property Specifications -->
            <div class="card">
                <div class="card-title">
                    <span class="icon">P</span>
                    Spesifikasi Properti
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Luas Tanah <span class="hint">(m²)</span></label>
                        <input type="number" name="LotArea" id="input-lot-area" value="{{ old('LotArea', $input['LotArea'] ?? '') }}" placeholder="Contoh: 743" required min="0" step="any">
                    </div>
                    <div class="form-group">
                        <label>Luas Bangunan <span class="hint">(m²)</span></label>
                        <input type="number" name="GrLivArea" id="input-gr-liv-area" value="{{ old('GrLivArea', $input['GrLivArea'] ?? '') }}" placeholder="Contoh: 139" required min="0" step="any">
                    </div>
                    <div class="form-group">
                        <label>Tahun Dibangun</label>
                        <input type="number" name="YearBuilt" id="input-year-built" value="{{ old('YearBuilt', $input['YearBuilt'] ?? '') }}" placeholder="Contoh: 2005" required min="1800" max="2030">
                    </div>
                    <div class="form-group">
                        <label>Zonasi Wilayah</label>
                        <select name="MSZoning" id="input-ms-zoning" required>
                            <option value="">-- Pilih Zonasi --</option>
                            @php $selectedZoning = old('MSZoning', $input['MSZoning'] ?? ''); @endphp
                            <option value="RL" {{ $selectedZoning === 'RL' ? 'selected' : '' }}>Perumahan Kepadatan Rendah</option>
                            <option value="RM" {{ $selectedZoning === 'RM' ? 'selected' : '' }}>Perumahan Kepadatan Sedang</option>
                            <option value="RH" {{ $selectedZoning === 'RH' ? 'selected' : '' }}>Perumahan Kepadatan Tinggi</option>
                            <option value="FV" {{ $selectedZoning === 'FV' ? 'selected' : '' }}>Desa Terapung</option>
                            <option value="C (all)" {{ $selectedZoning === 'C (all)' ? 'selected' : '' }}>Komersial</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Rooms -->
            <div class="card" style="animation-delay: 0.1s;">
                <div class="card-title">
                    <span class="icon">R</span>
                    Ruangan
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Kamar Tidur</label>
                        <input type="number" name="BedroomAbvGr" id="input-bedroom" value="{{ old('BedroomAbvGr', $input['BedroomAbvGr'] ?? '') }}" placeholder="Contoh: 3" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Kamar Mandi (Full Bath)</label>
                        <input type="number" name="FullBath" id="input-fullbath" value="{{ old('FullBath', $input['FullBath'] ?? '') }}" placeholder="Contoh: 2" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Dapur</label>
                        <input type="number" name="KitchenAbvGr" id="input-kitchen" value="{{ old('KitchenAbvGr', $input['KitchenAbvGr'] ?? '') }}" placeholder="Contoh: 1" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Total Ruangan <span class="hint">(tanpa kamar mandi)</span></label>
                        <input type="number" name="TotRmsAbvGrd" id="input-total-rooms" value="{{ old('TotRmsAbvGrd', $input['TotRmsAbvGrd'] ?? '') }}" placeholder="Contoh: 6" required min="0">
                    </div>
                </div>
            </div>

            <!-- Garage & Pool -->
            <div class="card" style="animation-delay: 0.2s;">
                <div class="card-title">
                    <span class="icon">G</span>
                    Garasi & Kolam Renang
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Luas Garasi <span class="hint">(m²)</span></label>
                        <input type="number" name="GarageArea" id="input-garage-area" value="{{ old('GarageArea', $input['GarageArea'] ?? '') }}" placeholder="Contoh: 37" required min="0" step="any">
                    </div>
                    <div class="form-group">
                        <label>Kapasitas Mobil di Garasi</label>
                        <input type="number" name="GarageCars" id="input-garage-cars" value="{{ old('GarageCars', $input['GarageCars'] ?? '') }}" placeholder="Contoh: 2" required min="0">
                    </div>
                    <div class="form-group full-width">
                        <label>Luas Kolam Renang <span class="hint">(m², isi 0 jika tidak ada)</span></label>
                        <input type="number" name="PoolArea" id="input-pool-area" value="{{ old('PoolArea', $input['PoolArea'] ?? '0') }}" placeholder="0" required min="0" step="any">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-predict" id="btn-predict">
                Prediksi Harga Rumah
            </button>
        </form>
    </div>

    <script>
        // Client-side validation: highlight empty required fields with red border
        document.getElementById('prediction-form').addEventListener('submit', function(e) {
            let hasError = false;
            const inputs = this.querySelectorAll('input[required], select[required]');

            inputs.forEach(function(input) {
                // Reset state
                input.classList.remove('input-error');

                // Check if empty
                if (!input.value || input.value.trim() === '') {
                    input.classList.add('input-error');
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
                // Scroll to first error
                const firstError = this.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Remove red border when user starts typing
        document.querySelectorAll('input, select').forEach(function(input) {
            input.addEventListener('input', function() {
                this.classList.remove('input-error');
            });
            input.addEventListener('change', function() {
                this.classList.remove('input-error');
            });
        });
    </script>
</body>
</html>
