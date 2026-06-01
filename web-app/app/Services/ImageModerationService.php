<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageModerationService
{
    /**
     * Verify if the uploaded image is safe and clean (not corrupted, and meets basic safety criteria).
     * In production, this can be connected to the Google Cloud Vision API or AWS Rekognition.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function isSafe(UploadedFile $file): bool
    {
        // 1. Integrity check: Verify file uploaded successfully without PHP errors
        if (!$file->isValid()) {
            return false;
        }

        // 2. Structural Image Validation: Verify the file is physically a valid image
        // (Prevents shell scripts masquerading as images with double extensions or modified headers)
        $realPath = $file->getRealPath();
        $imageInfo = @getimagesize($realPath);
        if ($imageInfo === false) {
            return false; // The file is not a valid image structure
        }

        // Verify that the actual mime type detected matches image types
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($imageInfo['mime'], $allowedMimes)) {
            return false;
        }

        // 3. API Cloud Moderation (Google Cloud Vision API integration example):
        /*
        try {
            $vision = new \Google\Cloud\Vision\V1\ImageAnnotatorClient([
                'credentials' => config('services.google.vision_key')
            ]);
            
            $image = file_get_contents($realPath);
            $response = $vision->safeSearchDetection($image);
            $safe = $response->getSafeSearchAnnotation();
            
            // Check levels: UNKNOWN, VERY_UNLIKELY, UNLIKELY, POSSIBLE, LIKELY, VERY_LIKELY
            if ($safe->getAdult() >= 3 || $safe->getMedical() >= 4 || $safe->getViolence() >= 3 || $safe->getRacy() >= 3) {
                return false; // Content is flagged as inappropriate
            }
        } catch (\Exception $e) {
            \Log::error('Vision API Error: ' . $e->getMessage());
        }
        */

        return true;
    }
}
