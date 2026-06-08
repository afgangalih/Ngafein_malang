<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SAWService
{
    public function calculate($cafes, array $bobot): array
    {
        $url = env('ENGINE_API_URL', 'http://127.0.0.1:8001');

        $payload = [
            'cafes' => $cafes->map(function ($cafe) {
                return [
                    'id_kafe' => (int)$cafe->id_kafe,
                    'nama_kafe' => (string)$cafe->nama_kafe,
                    'alamat' => (string)($cafe->alamat ?? ''),
                    'rating' => (float)($cafe->rating ?? 0.0),
                    'jarak' => (float)($cafe->jarak ?? 0.0),
                    'harga_min' => (int)($cafe->harga_min ?? 0),
                    'harga_max' => (int)($cafe->harga_max ?? 0),
                    'jam_buka' => $cafe->jam_buka ? substr($cafe->jam_buka, 0, 5) : null,
                    'jam_tutup' => $cafe->jam_tutup ? substr($cafe->jam_tutup, 0, 5) : null,
                    'gambar' => ($cafe->relationLoaded('gambar') && $cafe->gambar) ? ($cafe->gambar->first()?->link_gambar ?? null) : null,
                    'fasilitas_count' => (int)($cafe->fasilitas ? $cafe->fasilitas->count() : 0),
                    'menu_count' => (int)($cafe->menus ? $cafe->menus->count() : 0),
                ];
            })->toArray(),
            'bobot' => [
                'harga' => (float)$bobot['harga'],
                'rating' => (float)$bobot['rating'],
                'jarak' => (float)$bobot['jarak'],
                'fasilitas' => (float)$bobot['fasilitas'],
                'menu' => (float)$bobot['menu'],
                'jam_operasional' => (float)$bobot['jam_operasional'],
            ]
        ];

        try {
            $response = Http::timeout(10)->post($url . '/api/saw/calculate', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                $hasilMapped = collect($data['hasil'])->map(function ($item) {
                    return array_merge($item, [
                        'rating_raw' => $item['rating'],
                        'jarak_km' => $item['jarak'],
                        'harga_rata_rata' => ($item['harga_min'] + $item['harga_max']) / 2
                    ]);
                });

                return [
                    'hasil' => $hasilMapped,
                    'matriks' => collect($data['matriks']),
                    'normalisasi' => collect($data['normalisasi'])
                ];
            }

            throw new \Exception('Engine returned status code ' . $response->status());
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghubungi engine perhitungan SAW: ' . $e->getMessage());
        }
    }
}
