from fastapi import FastAPI
from .schemas import SAWRequest, SAWResponse
from .saw_engine import hitung_saw_proses

app = FastAPI(title="Ngafein SAW Recommendation Engine")

@app.post("/api/saw/calculate", response_model=SAWResponse)
async def calculate_saw(request: SAWRequest):
    print(f"[SAW Engine] Menerima request perhitungan untuk {len(request.cafes)} kafe.")
    return hitung_saw_proses(request.cafes, request.bobot)
