<?php
// Buat gambar kosong dengan ukuran 200x80 pixels
$image = imagecreatetruecolor(200, 80);

// Warna background
$bg_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);

// Warna text
$text_color = imagecolorallocate($image, 0, 102, 204); 

// Tambahkan text ke gambar
imagestring($image, 5, 40, 30, 'DapurKode', $text_color);

// Output gambar
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
