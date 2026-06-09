<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KafeModel;
use App\Models\KafeGambarModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KafeGambarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assetsPath = database_path('seeders/assets/Foto Kafe New');

        if (!File::isDirectory($assetsPath)) {
            $this->command->error("Folder aset foto tidak ditemukan di: {$assetsPath}");
            return;
        }

        // Ambil semua sub-direktori (folder kafe)
        $folders = File::directories($assetsPath);
        $totalMapped = 0;

        // Ambil semua data kafe dari database untuk dicocokkan
        $kafes = KafeModel::all();

        if ($kafes->isEmpty()) {
            $this->command->error("Tidak ada data kafe di database. Jalankan KafeSeeder terlebih dahulu!");
            return;
        }

        $this->command->info("Memulai pencocokan foto dengan kafe di database...");

        foreach ($folders as $folderPath) {
            $folderName = basename($folderPath);
            $normalizedFolderName = $this->normalizeString($folderName);

            // Cari kafe yang paling cocok di database
            $matchedCafe = $kafes->first(function ($cafe) use ($normalizedFolderName) {
                $normalizedCafeName = $this->normalizeString($cafe->nama_kafe);
                
                // Pencocokan eksak setelah normalisasi
                if ($normalizedCafeName === $normalizedFolderName) {
                    return true;
                }

                // Pencocokan parsial (saling mengandung string satu sama lain)
                if (Str::contains($normalizedCafeName, $normalizedFolderName) || Str::contains($normalizedFolderName, $normalizedCafeName)) {
                    return true;
                }

                return false;
            });

            if ($matchedCafe) {
                // Cari semua file di dalam folder tersebut (webp, jpeg, jpg, png, dll)
                $files = File::files($folderPath);

                if (empty($files)) {
                    continue;
                }

                // Siapkan direktori tujuan di public storage: storage/app/public/cafes/{id_kafe}/
                $destinationSubDir = "cafes/{$matchedCafe->id_kafe}";
                $destinationPath = storage_path("app/public/{$destinationSubDir}");

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                foreach ($files as $file) {
                    $filename = $file->getFilename();
                    $targetPath = "{$destinationSubDir}/{$filename}";
                    $absoluteTargetPath = "{$destinationPath}/{$filename}";

                    // Salin file fisik
                    File::copy($file->getRealPath(), $absoluteTargetPath);

                    // Catat ke database jika belum ada untuk mencegah duplikasi
                    $exists = KafeGambarModel::where('id_kafe', $matchedCafe->id_kafe)
                        ->where('path_gambar', $targetPath)
                        ->exists();

                    if (!$exists) {
                        KafeGambarModel::create([
                            'id_kafe' => $matchedCafe->id_kafe,
                            'path_gambar' => $targetPath
                        ]);
                    }
                }

                $this->command->info("✔ Berhasil memetakan folder [{$folderName}] ke kafe [{$matchedCafe->nama_kafe}] (ID: {$matchedCafe->id_kafe}) dengan " . count($files) . " foto.");
                $totalMapped++;
            } else {
                $this->command->warn("⚠ Tidak ada kecocokan kafe di database untuk folder: [{$folderName}]");
            }
        }

        $this->command->info("=== Selesai! Berhasil memetakan {$totalMapped} dari " . count($folders) . " folder kafe. ===");
    }

    /**
     * Normalisasi string untuk pencocokan toleran
     */
    private function normalizeString(string $string): string
    {
        // Ubah ke lowercase
        $string = strtolower($string);
        // Hapus karakter non-alphanumeric (tanda baca, simbol, tanda hubung)
        $string = preg_replace('/[^a-z0-9]/', '', $string);
        return $string;
    }
}
