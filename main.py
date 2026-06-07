from fastapi import FastAPI
from pydantic import BaseModel
# Import model_data dan fungsi prediksi dari subfolder models
from models.load_model import model_data, predict_house_price

# Inisialisasi aplikasi FastAPI
app = FastAPI(title="House Price Predictor API")

# 1. Definisikan skema data input yang dikirim dari Laravel
class HouseFeatures(BaseModel):
    LotArea: float
    GrLivArea: float
    FullBath: float
    BedroomAbvGr: float
    KitchenAbvGr: float
    TotRmsAbvGrd: float
    GarageArea: float
    GarageCars: float
    PoolArea: float
    YearBuilt: float
    MSZoning: str

# 2. Endpoint utama untuk melakukan prediksi harga
@app.post("/predict")
def predict_price(features: HouseFeatures):
    # Mengubah data input Pydantic menjadi format dictionary Python biasa
    input_data = features.dict()
    
    # Memanggil fungsi prediksi (dari load_model.py)
    predicted_price = predict_house_price(input_data, model_data)
    
    # Mengembalikan hasil prediksi dalam bentuk JSON
    return {
        "status": "success",
        "predicted_price": round(predicted_price, 2)
    }

# 3. Endpoint opsional untuk mengecek status API
@app.get("/")
def read_root():
    return {"message": "House Price Prediction API is running!"}
