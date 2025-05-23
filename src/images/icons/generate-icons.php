<?php
// Create a 512x512 image
$image = imagecreatetruecolor(512, 512);

// Define colors
$navy = imagecolorallocate($image, 0, 31, 63); // #001f3f
$white = imagecolorallocate($image, 255, 255, 255);

// Fill background
imagefill($image, 0, 0, $navy);

// Draw a white circle for the bag
imagefilledellipse($image, 256, 256, 400, 400, $white);

// Draw the dollar sign
$dollar = imagecolorallocate($image, 0, 31, 63);
imageline($image, 256, 160, 256, 352, $dollar);
imagearc($image, 256, 224, 64, 64, 0, 360, $dollar);
imagearc($image, 256, 288, 64, 64, 0, 360, $dollar);

// Save in different sizes
$sizes = [72, 96, 128, 144, 152, 192, 384, 512];
foreach ($sizes as $size) {
    $resized = imagecreatetruecolor($size, $size);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $size, $size, 512, 512);
    imagepng($resized, "icon-{$size}x{$size}.png");
    imagedestroy($resized);
}

imagedestroy($image);
echo "Icons generated successfully!\n";
?> 