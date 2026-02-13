<?php

namespace App;

class ImageOptimizer
{
    private static $cacheDir;
    private static $webpSupported = null;
    
    public static function init()
    {
        self::$cacheDir = __DIR__ . '/../storage/cache/images';
        
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }
    
    public static function getOptimizedImage($imagePath, $width = null, $height = null, $quality = 85)
    {
        $originalPath = __DIR__ . '/../public/' . ltrim($imagePath, '/');
        
        if (!file_exists($originalPath)) {
            return $imagePath;
        }
        
        $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
        $filename = pathinfo($originalPath, PATHINFO_FILENAME);
        $dir = pathinfo($originalPath, PATHINFO_DIRNAME);
        
        // Generate cache key
        $cacheKey = md5($imagePath . $width . $height . $quality);
        $cacheFile = self::$cacheDir . '/' . $cacheKey . '.' . $extension;
        
        // Check if cached version exists
        if (file_exists($cacheFile) && filemtime($cacheFile) > filemtime($originalPath)) {
            return '/storage/cache/images/' . basename($cacheFile);
        }
        
        // Create optimized version
        $optimizedPath = self::createOptimizedImage($originalPath, $cacheFile, $width, $height, $quality);
        
        return $optimizedPath ? '/storage/cache/images/' . basename($optimizedPath) : $imagePath;
    }
    
    public static function getWebpImage($imagePath, $width = null, $height = null, $quality = 85)
    {
        if (!self::isWebpSupported()) {
            return self::getOptimizedImage($imagePath, $width, $height, $quality);
        }
        
        $originalPath = __DIR__ . '/../public/' . ltrim($imagePath, '/');
        
        if (!file_exists($originalPath)) {
            return $imagePath;
        }
        
        $filename = pathinfo($originalPath, PATHINFO_FILENAME);
        $cacheKey = md5($imagePath . $width . $height . $quality . 'webp');
        $webpFile = self::$cacheDir . '/' . $cacheKey . '.webp';
        
        // Check if WebP version exists
        if (file_exists($webpFile) && filemtime($webpFile) > filemtime($originalPath)) {
            return '/storage/cache/images/' . basename($webpFile);
        }
        
        // Create WebP version
        $webpPath = self::createWebpImage($originalPath, $webpFile, $width, $height, $quality);
        
        return $webpPath ? '/storage/cache/images/' . basename($webpPath) : $imagePath;
    }
    
    private static function createOptimizedImage($originalPath, $outputPath, $width, $height, $quality)
    {
        $imageInfo = getimagesize($originalPath);
        $mimeType = $imageInfo['mime'];
        
        // Create image resource
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($originalPath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($originalPath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($originalPath);
                break;
            default:
                return false;
        }
        
        if (!$image) {
            return false;
        }
        
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);
        
        // Calculate dimensions if not specified
        if (!$width && !$height) {
            $width = $originalWidth;
            $height = $originalHeight;
        } elseif ($width && !$height) {
            $height = ($originalHeight * $width) / $originalWidth;
        } elseif (!$width && $height) {
            $width = ($originalWidth * $height) / $originalHeight;
        }
        
        // Create resized image
        $resizedImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $width, $height, $transparent);
        }
        
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        
        // Save optimized image
        $extension = pathinfo($outputPath, PATHINFO_EXTENSION);
        $success = false;
        
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $success = imagejpeg($resizedImage, $outputPath, $quality);
                break;
            case 'png':
                $success = imagepng($resizedImage, $outputPath, 9);
                break;
            case 'webp':
                $success = imagewebp($resizedImage, $outputPath, $quality);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($resizedImage);
        
        return $success ? $outputPath : false;
    }
    
    private static function createWebpImage($originalPath, $webpPath, $width, $height, $quality)
    {
        if (!self::isWebpSupported()) {
            return false;
        }
        
        $imageInfo = getimagesize($originalPath);
        $mimeType = $imageInfo['mime'];
        
        // Create image resource
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($originalPath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($originalPath);
                break;
            default:
                return false;
        }
        
        if (!$image) {
            return false;
        }
        
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);
        
        // Calculate dimensions
        if (!$width && !$height) {
            $width = $originalWidth;
            $height = $originalHeight;
        } elseif ($width && !$height) {
            $height = ($originalHeight * $width) / $originalWidth;
        } elseif (!$width && $height) {
            $width = ($originalWidth * $height) / $originalHeight;
        }
        
        // Create resized image
        $resizedImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
        imagefilledrectangle($resizedImage, 0, 0, $width, $height, $transparent);
        
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        
        // Save as WebP
        $success = imagewebp($resizedImage, $webpPath, $quality);
        
        imagedestroy($image);
        imagedestroy($resizedImage);
        
        return $success ? $webpPath : false;
    }
    
    private static function isWebpSupported()
    {
        if (self::$webpSupported === null) {
            self::$webpSupported = function_exists('imagewebp') && function_exists('imagecreatefromwebp');
        }
        
        return self::$webpSupported;
    }
    
    public static function generatePictureElement($imagePath, $alt = '', $width = null, $height = null, $class = '')
    {
        $webpPath = self::getWebpImage($imagePath, $width, $height);
        $fallbackPath = self::getOptimizedImage($imagePath, $width, $height);
        
        $picture = '<picture>';
        $picture .= '<source srcset="' . $webpPath . '" type="image/webp">';
        $picture .= '<img src="' . $fallbackPath . '" alt="' . htmlspecialchars($alt) . '" class="' . $class . '" loading="lazy">';
        $picture .= '</picture>';
        
        return $picture;
    }
}
