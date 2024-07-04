<?php

namespace App\Helpers;

class BarcodeHelper
{
    /**
     * Generate Code 39 barcode image data URI.
     *
     * @param string $text
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function generateCode39Barcode($text, $width = 300, $height = 50)
    {
        // Check if GD extension is loaded
        if (!function_exists('imagecreate')) {
            throw new \Exception('GD library is not available.');
        }

        // Create image resource
        $image = imagecreatetruecolor($width, $height);

        // Allocate colors
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        // Fill background with white color
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Generate barcode (example with Code 39)
        $barcode = self::barcode_encode($text);

        // Draw barcode using imagestring function (adjust parameters as needed)
        imagestring($image, 5, 5, 5, $barcode, $black);

        // Output the image directly as base64 data URI
        ob_start();
        imagepng($image);
        $image_data = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($image_data);
    }

    /**
     * Encode text to Code 39 barcode format.
     *
     * @param string $text
     * @return string
     */
    private static function barcode_encode($text)
    {
        // Implement your encoding logic here (example Code 39 encoding)
        // Replace with your own logic for encoding barcode

        return '*' . strtoupper($text) . '*'; // Example Code 39 encoding
    }
}
