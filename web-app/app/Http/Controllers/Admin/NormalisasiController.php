<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NormalisasiController extends Controller
{
    public function index()
    {
        $normalisasi = [
            [
                'nama' => 'KAF Cafe',
                'harga' => 0.35,
                'rating' => 0.90,
                'jarak' => 1.00,
                'fasilitas' => 0.80,
                'menu' => 1.00,
                'durasi' => 0.79,
            ],
            [
                'nama' => 'Nakoa Cafe Suhat',
                'harga' => 0.35,
                'rating' => 0.98,
                'jarak' => 0.26,
                'fasilitas' => 0.80,
                'menu' => 0.80,
                'durasi' => 0.63,
            ],
            [
                'nama' => 'Nakoa Cafe Panderman',
                'harga' => 0.35,
                'rating' => 1.00,
                'jarak' => 0.39,
                'fasilitas' => 0.90,
                'menu' => 0.80,
                'durasi' => 0.63,
            ],
            [
                'nama' => 'Semusim Cafe',
                'harga' => 1.00,
                'rating' => 0.92,
                'jarak' => 0.92,
                'fasilitas' => 1.00,
                'menu' => 1.00,
                'durasi' => 0.79,
            ],
            [
                'nama' => 'Roketto Coffee',
                'harga' => 0.35,
                'rating' => 0.92,
                'jarak' => 0.42,
                'fasilitas' => 0.80,
                'menu' => 0.80,
                'durasi' => 1.00,
            ],
            [
                'nama' => 'Pesenkopi',
                'harga' => 0.35,
                'rating' => 0.98,
                'jarak' => 0.69,
                'fasilitas' => 0.80,
                'menu' => 1.00,
                'durasi' => 0.53,
            ],
            [
                'nama' => 'Swara Bunga Cafe',
                'harga' => 1.00,
                'rating' => 0.84,
                'jarak' => 0.20,
                'fasilitas' => 0.80,
                'menu' => 1.00,
                'durasi' => 1.00,
            ],
        ];

        return view('admin.normalisasi.index', compact('normalisasi'));
    }
}