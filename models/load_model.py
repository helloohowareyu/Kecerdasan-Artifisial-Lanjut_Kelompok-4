import json
import os

model_path = os.path.join(os.path.dirname(__file__), 'house_price_model.joblib')

try:
    with open(model_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Format file ini kustom: 16 karakter pertama adalah "MYMODEL1       _"
    # dan sisanya adalah string JSON. Kita potong 16 karakter pertama.
    json_content = content[16:]
    
    # Load JSON
    model_data = json.loads(json_content)
    
    print(f"[OK] Model '{model_data.get('type')}' berhasil dimuat.")

except Exception as e:
    print("=== GAGAL MEMUAT MODEL ===")
    print("Error:", e)
    model_data = None

def predict_house_price(input_data, model_data):
    # 1. Ambil konfigurasi model
    features_num = model_data["features_num"]
    mszoning_categories = model_data["mszoning_categories"]
    
    # 2. Bangun array input mentah (X_raw)
    # Masukkan nilai numerik sesuai urutan
    X_raw = [float(input_data[feat]) for feat in features_num]
    
    # Lakukan One-Hot Encoding untuk MSZoning
    user_zoning = input_data.get("MSZoning")
    for cat in mszoning_categories:
        if user_zoning == cat:
            X_raw.append(1.0)
        else:
            X_raw.append(0.0)
            
    # 3. Standardisasi Input (X_scaled) menggunakan X_mean dan X_std
    X_mean = model_data["X_mean"]
    X_std = model_data["X_std"]
    X_scaled = []
    for i in range(len(X_raw)):
        scaled_val = (X_raw[i] - X_mean[i]) / X_std[i]
        X_scaled.append(scaled_val)
        
    # 4. Hitung prediksi skala (y_scaled)
    # weights[0] adalah Intercept (bias), weights[1:] adalah koefisien fitur
    weights = model_data["weights"]
    y_scaled = weights[0]
    for i in range(len(X_scaled)):
        y_scaled += X_scaled[i] * weights[i+1]
        
    # 5. Kembalikan y_scaled ke harga rumah sebenarnya
    y_mean = model_data["y_mean"]
    y_std = model_data["y_std"]
    y_pred = (y_scaled * y_std) + y_mean
    
    return y_pred