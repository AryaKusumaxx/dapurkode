<?php

// File path yang ingin diperiksa
$filePath = __DIR__ . '/storage/images/partners/partner-1.svg';

echo "<h1>File SVG Debug</h1>";

// Cek apakah file ada
if (file_exists($filePath)) {
    echo "<p style='color:green'>File ada di: " . $filePath . "</p>";
    
    // Tampilkan ukuran file
    echo "<p>Ukuran file: " . filesize($filePath) . " bytes</p>";
    
    // Cek apakah file bisa dibaca
    if (is_readable($filePath)) {
        echo "<p style='color:green'>File bisa dibaca</p>";
        
        // Tampilkan 100 byte pertama dari file
        $content = file_get_contents($filePath);
        echo "<p>Isi file (100 byte pertama): <pre>" . htmlspecialchars(substr($content, 0, 100)) . "...</pre></p>";
        
        // Cek MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filePath);
        echo "<p>MIME Type: " . $mime . "</p>";
        finfo_close($finfo);
        
        // Jika ini adalah file SVG valid, tampilkan SVG
        if (strpos($mime, 'image/svg') !== false || strpos($mime, 'text/plain') !== false || strpos($mime, 'text/xml') !== false) {
            echo "<p>Menampilkan SVG:</p>";
            echo "<div style='border:1px solid #ccc; padding: 10px; width: 300px; height: 100px;'>";
            echo file_get_contents($filePath);
            echo "</div>";
        }
    } else {
        echo "<p style='color:red'>File tidak bisa dibaca!</p>";
    }
} else {
    echo "<p style='color:red'>File tidak ditemukan di: " . $filePath . "</p>";
    
    // Cek folder storage images/partners
    $dir = __DIR__ . '/storage/images/partners';
    
    if (is_dir($dir)) {
        echo "<p style='color:green'>Direktori ada: " . $dir . "</p>";
        echo "<p>Isi direktori:</p><ul>";
        
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                echo "<li>" . $file . " (" . filesize($dir . '/' . $file) . " bytes)</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red'>Direktori tidak ditemukan: " . $dir . "</p>";
    }
    
    // Cek symlink
    $publicPath = __DIR__ . '/storage';
    $targetPath = realpath(__DIR__ . '/../storage/app/public');
    
    echo "<p>Symlink info:</p>";
    echo "<ul>";
    echo "<li>Public path: " . $publicPath . (file_exists($publicPath) ? " (exists)" : " (does not exist)") . "</li>";
    echo "<li>Target path: " . $targetPath . (file_exists($targetPath) ? " (exists)" : " (does not exist)") . "</li>";
    
    if (is_link($publicPath)) {
        echo "<li>Is symlink: Yes</li>";
        echo "<li>Symlink target: " . readlink($publicPath) . "</li>";
    } else {
        echo "<li>Is symlink: No</li>";
    }
    
    echo "</ul>";
}
?>
