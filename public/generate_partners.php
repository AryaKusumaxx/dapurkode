<?php
// This script generates placeholder logos for partners
$width = 300;
$height = 100;
$partners = ['Partner 1', 'Partner 2', 'Partner 3', 'Partner 4', 'Partner 5'];
$colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];

// Create the partners directory if it doesn't exist
$dir = __DIR__ . '/storage/images/partners';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

foreach ($partners as $index => $name) {
    $color = $colors[$index % count($colors)];
    
    // Create image
    $image = imagecreatetruecolor($width, $height);
    
    // Set background to white
    $white = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $white);
    
    // Set text color
    $textColor = imagecolorallocate($image, hexdec(substr($color, 1, 2)), 
                                    hexdec(substr($color, 3, 2)), 
                                    hexdec(substr($color, 5, 2)));
    
    // Add border
    $borderColor = imagecolorallocate($image, 220, 220, 220);
    imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);
    
    // Add text
    $font = 5; // Built-in font
    $text = $name;
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $font, $x, $y, $text, $textColor);
    
    // Save image
    $filename = $dir . '/partner-' . ($index + 1) . '.png';
    imagepng($image, $filename);
    imagedestroy($image);
    
    echo "Generated: $filename\n";
}

echo "All partner logos generated successfully!\n";
?>
