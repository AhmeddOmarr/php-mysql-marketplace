<?php
// Function to convert SVG to PNG
function svgToPng($svg, $size) {
    // Create a new image
    $image = imagecreatetruecolor($size, $size);
    
    // Define colors
    $navy = imagecolorallocate($image, 0, 31, 63); // #001f3f
    $white = imagecolorallocate($image, 255, 255, 255);
    
    // Fill background
    imagefill($image, 0, 0, $navy);
    
    // Draw white circle for the bag
    $bagSize = $size * 0.8;
    $bagX = ($size - $bagSize) / 2;
    $bagY = ($size - $bagSize) / 2;
    imagefilledellipse($image, $size/2, $size/2, $bagSize, $bagSize, $white);
    
    // Draw dollar sign
    $dollarSize = $size * 0.4;
    $dollarX = ($size - $dollarSize) / 2;
    $dollarY = ($size - $dollarSize) / 2;
    
    // Vertical line
    imageline($image, $size/2, $dollarY + $dollarSize*0.2, $size/2, $dollarY + $dollarSize*0.8, $navy);
    
    // Top curve
    imagearc($image, $size/2, $dollarY + $dollarSize*0.4, $dollarSize*0.4, $dollarSize*0.4, 0, 360, $navy);
    
    // Bottom curve
    imagearc($image, $size/2, $dollarY + $dollarSize*0.6, $dollarSize*0.4, $dollarSize*0.4, 0, 360, $navy);
    
    return $image;
}

// Generate icons in different sizes
$sizes = [72, 96, 128, 144, 152, 192, 384, 512];

foreach ($sizes as $size) {
    $image = svgToPng(null, $size);
    imagepng($image, "icon-{$size}x{$size}.png");
    imagedestroy($image);
    echo "Generated icon-{$size}x{$size}.png\n";
}

echo "All icons generated successfully!\n";
?> 