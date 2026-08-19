<?php
/**
 * Image Compression Helper for PARFY.ID
 * Auto-compress uploaded images to WebP format
 */

/**
 * Compress and convert image to WebP
 * @param string $sourcePath Path to original image
 * @param string $destPath Destination path for compressed image
 * @param int $quality Quality 1-100 (default: 75 for product cards)
 * @param int $maxWidth Maximum width (default: 800px)
 * @return bool Success status
 */
function compressImage(string $sourcePath, string $destPath, int $quality = 75, int $maxWidth = 800): bool
{
    // Check if file exists
    if (!file_exists($sourcePath)) {
        error_log("CompressImage: Source file not found: $sourcePath");
        return false;
    }

    // Check GD library
    if (!extension_loaded('gd')) {
        error_log("CompressImage: GD library not installed");
        return false;
    }

    // Get image info
    $imageInfo = @getimagesize($sourcePath);
    if ($imageInfo === false) {
        error_log("CompressImage: Invalid image file: $sourcePath");
        return false;
    }

    [$width, $height, $type] = $imageInfo;

    // Load image based on type
    $sourceImage = null;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = @imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = @imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = @imagecreatefromgif($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            if (function_exists('imagecreatefromwebp')) {
                $sourceImage = @imagecreatefromwebp($sourcePath);
            }
            break;
        default:
            error_log("CompressImage: Unsupported image type: $type");
            return false;
    }

    if ($sourceImage === false || $sourceImage === null) {
        error_log("CompressImage: Failed to create image from source: $sourcePath (type: $type)");
        return false;
    }

    // Calculate new dimensions (maintain aspect ratio)
    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int) (($height / $width) * $maxWidth);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    // Create new image with resampling (better quality)
    $destImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    imagealphablending($destImage, false);
    imagesavealpha($destImage, true);

    // Fill with white background (for JPEG fallback)
    $white = imagecolorallocate($destImage, 255, 255, 255);
    imagefill($destImage, 0, 0, $white);
    imagealphablending($destImage, true);

    // Resample image
    imagecopyresampled(
        $destImage,
        $sourceImage,
        0,
        0,
        0,
        0,
        $newWidth,
        $newHeight,
        $width,
        $height
    );

    // Check WebP support and save
    $success = false;
    $webpSupport = function_exists('imagewebp') && (imagetypes() & IMG_WEBP);

    if ($webpSupport) {
        // Save as WebP
        $success = @imagewebp($destImage, $destPath, $quality);
        if (!$success) {
            error_log("CompressImage: imagewebp failed, trying JPEG fallback");
        }
    }

    // Fallback to JPEG if WebP failed or not supported
    if (!$success) {
        // Change extension to .jpg
        $destPath = preg_replace('/\.webp$/i', '.jpg', $destPath);
        $success = @imagejpeg($destImage, $destPath, $quality);
        if ($success) {
            error_log("CompressImage: Saved as JPEG (WebP not supported)");
        }
    }

    // Free memory
    imagedestroy($sourceImage);
    imagedestroy($destImage);

    if ($success) {
        // Log compression stats
        $originalSize = filesize($sourcePath);
        $compressedSize = filesize($destPath);
        $savedPercent = round((1 - $compressedSize / $originalSize) * 100, 1);
        error_log("CompressImage: {$sourcePath} ({$originalSize}b) -> {$destPath} ({$compressedSize}b) - Saved {$savedPercent}%");
    } else {
        error_log("CompressImage: All save methods failed for $sourcePath");
    }

    return $success;
}

/**
 * Compress image with preset for product cards
 * @param string $sourcePath Source image path
 * @param string $destPath Destination path
 * @return bool Success status
 */
function compressProductCard(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 75, 800);
}

/**
 * Compress image with preset for product detail
 * @param string $sourcePath Source image path
 * @param string $destPath Destination path
 * @return bool Success status
 */
function compressProductDetail(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 85, 1200);
}

/**
 * Compress image with preset for thumbnails
 * @param string $sourcePath Source image path
 * @param string $destPath Destination path
 * @return bool Success status
 */
function compressProductThumbnail(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 70, 400);
}
