<?php
// This PHP script generates a simple placeholder image for products

// Set header content type
header('Content-Type: image/jpeg');

// Create a blank image
$width = 400;
$height = 400;
$image = imagecreatetruecolor($width, $height);

// Define colors
$background = imagecolorallocate($image, 240, 240, 240); // Light gray
$textColor = imagecolorallocate($image, 80, 80, 80);     // Dark gray
$accentColor = imagecolorallocate($image, 64, 105, 225);  // Royal blue

// Fill the background
imagefill($image, 0, 0, $background);

// Draw a border
imagerectangle($image, 0, 0, $width-1, $height-1, $accentColor);
imagerectangle($image, 10, 10, $width-11, $height-11, $accentColor);

// Add a product icon in the center
$center_x = $width / 2;
$center_y = $height / 2;
$box_size = 120;

// Draw product box icon
imagefilledrectangle(
    $image,
    $center_x - $box_size/2,
    $center_y - $box_size/2,
    $center_x + $box_size/2,
    $center_y + $box_size/2,
    $accentColor
);

// Add text below icon
$text = "Product Image";
$font_size = 5; // Built-in font size

// Get text dimensions
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);

// Position text
$text_x = $center_x - ($text_width / 2);
$text_y = $center_y + $box_size/2 + 20;

// Add text to image
imagestring($image, $font_size, $text_x, $text_y, $text, $textColor);

// Output the image
imagejpeg($image, null, 90);

// Free memory
imagedestroy($image);
?>
