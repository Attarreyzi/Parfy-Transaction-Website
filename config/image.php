<?php
/**
 * Kompresi dan Pengolahan Gambar PARFY.ID
 */

/**
 * Kompresi dan konversi gambar ke format WebP
 */
function compressImage(string $sourcePath, string $destPath, int $quality = 75, int $maxWidth = 800): bool
{
    if (!file_exists($sourcePath)) {
        error_log("CompressImage: File sumber tidak ditemukan: $sourcePath");
        return false;
    }

    if (!extension_loaded('gd')) {
        error_log("CompressImage: Ekstensi GD tidak aktif");
        return false;
    }

    $imageInfo = @getimagesize($sourcePath);
    if ($imageInfo === false) {
        error_log("CompressImage: File gambar tidak valid: $sourcePath");
        return false;
    }

    [$width, $height, $type] = $imageInfo;

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
            error_log("CompressImage: Tipe gambar tidak didukung: $type");
            return false;
    }

    if (!$sourceImage) {
        error_log("CompressImage: Gagal membuat gambar dari sumber: $sourcePath");
        return false;
    }

    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int) (($height / $width) * $maxWidth);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $destImage = imagecreatetruecolor($newWidth, $newHeight);

    imagealphablending($destImage, false);
    imagesavealpha($destImage, true);

    $white = imagecolorallocate($destImage, 255, 255, 255);
    imagefill($destImage, 0, 0, $white);
    imagealphablending($destImage, true);

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

    $success = false;
    $webpSupport = function_exists('imagewebp') && (imagetypes() & IMG_WEBP);

    if ($webpSupport) {
        $success = @imagewebp($destImage, $destPath, $quality);
    }

    if (!$success) {
        $destPath = preg_replace('/\.webp$/i', '.jpg', $destPath);
        $success = @imagejpeg($destImage, $destPath, $quality);
    }

    imagedestroy($sourceImage);
    imagedestroy($destImage);

    return $success;
}

/**
 * Kompresi gambar kartu produk
 */
function compressProductCard(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 75, 800);
}

/**
 * Kompresi gambar detail produk
 */
function compressProductDetail(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 85, 1200);
}

/**
 * Kompresi gambar thumbnail produk
 */
function compressProductThumbnail(string $sourcePath, string $destPath): bool
{
    return compressImage($sourcePath, $destPath, 70, 400);
}

