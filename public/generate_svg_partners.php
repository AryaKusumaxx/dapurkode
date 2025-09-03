<?php
// Create a simple SVG placeholder
function createSVG($filename, $text, $color) {
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="300" height="100" viewBox="0 0 300 100">
  <rect width="298" height="98" x="1" y="1" fill="white" stroke="#ddd" stroke-width="2" rx="5" ry="5"/>
  <text x="150" y="50" font-family="Arial" font-size="24" fill="{$color}" text-anchor="middle" dominant-baseline="middle">{$text}</text>
</svg>
SVG;
    
    file_put_contents($filename, $svg);
    echo "Created $filename\n";
}

// Create partners directory if it doesn't exist
$dir = __DIR__ . '/storage/images/partners';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Create partner SVGs
$partners = [
    ['Partner 1', '#3b82f6'],
    ['Partner 2', '#10b981'],
    ['Partner 3', '#f59e0b'],
    ['Partner 4', '#ef4444'],
    ['Partner 5', '#8b5cf6']
];

foreach ($partners as $index => $partner) {
    createSVG("$dir/partner-" . ($index + 1) . ".svg", $partner[0], $partner[1]);
}

echo "All SVG partner logos created successfully!\n";
?>
