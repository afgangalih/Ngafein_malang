<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KafeModel;
use App\Models\KafeGambarModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;

class MigrateCafeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cafe:migrate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate cafe images from external "Foto Kafe" folder to Laravel storage and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourcePath = base_path('../Foto Kafe');
        $destPath = 'public/cafes';

        if (!File::exists($sourcePath)) {
            $this->error("Folder sumber tidak ditemukan di: $sourcePath");
            return;
        }

        $folders = File::directories($sourcePath);
        $this->info("Ditemukan " . count($folders) . " folder kafe di sumber.");

        $cafes = KafeModel::all();
        $successCount = 0;
        $failedFolders = [];

        foreach ($folders as $folderPath) {
            $folderName = basename($folderPath);
            $matchedCafe = $this->findMatchedCafe($folderName, $cafes);

            if ($matchedCafe) {
                $this->info("Matching: [ $folderName ] -> [ $matchedCafe->nama_kafe ] (ID: $matchedCafe->id_kafe)");
                
                $images = File::files($folderPath);
                foreach ($images as $image) {
                    $fileName = $image->getFilename();
                    $safeFileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $image->getExtension();
                    $newPath = "cafes/" . $matchedCafe->id_kafe . "/" . $safeFileName;

                    // Copy file to storage
                    Storage::disk('public')->put($newPath, File::get($image));

                    // Save to database
                    KafeGambarModel::updateOrCreate([
                        'id_kafe' => $matchedCafe->id_kafe,
                        'path_gambar' => $newPath
                    ]);
                }
                
                $successCount++;
            } else {
                $failedFolders[] = $folderName;
                $this->warn("No match found for folder: [ $folderName ]");
            }
        }

        $this->newLine();
        $this->info("Migrasi Selesai!");
        $this->info("Berhasil menjodohkan: $successCount kafe.");
        
        if (count($failedFolders) > 0) {
            $this->warn("Daftar folder yang tidak ketemu pasangannya di DB:");
            foreach ($failedFolders as $fail) {
                $this->line("- $fail");
            }
        }
        
        $this->info("Pastikan untuk menjalankan 'php artisan storage:link' jika belum.");
    }

    /**
     * Intelligent matching logic
     */
    private function findMatchedCafe($folderName, $cafes)
    {
        $cleanFolderName = Str::slug($folderName);

        // 1. Try exact slug match
        foreach ($cafes as $cafe) {
            if (Str::slug($cafe->nama_kafe) === $cleanFolderName) {
                return $cafe;
            }
        }

        // 2. Try partial match (if folder name is part of cafe name)
        foreach ($cafes as $cafe) {
            $cleanCafeName = Str::slug($cafe->nama_kafe);
            if (str_contains($cleanCafeName, $cleanFolderName) || str_contains($cleanFolderName, $cleanCafeName)) {
                return $cafe;
            }
        }

        // 3. Try fuzzy match (removing common words)
        $stopWords = ['coffee', 'cafe', 'and', 'eatery', 'plus', 'plus-klojen'];
        $simplifiedFolder = str_replace($stopWords, '', $cleanFolderName);
        
        foreach ($cafes as $cafe) {
            $simplifiedCafe = str_replace($stopWords, '', Str::slug($cafe->nama_kafe));
            if (str_contains($simplifiedCafe, $simplifiedFolder) || str_contains($simplifiedFolder, $simplifiedCafe)) {
                return $cafe;
            }
        }

        return null;
    }
}
