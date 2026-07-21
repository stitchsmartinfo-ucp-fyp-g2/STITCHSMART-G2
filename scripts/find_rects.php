<?php
function get_black_rect($file) {
    if (!file_exists($file)) return "Not found: $file\n";
    $img = imagecreatefrompng($file);
    if (!$img) return "Failed to load: $file\n";
    
    $width = imagesx($img);
    $height = imagesy($img);
    
    $minX = $width; $maxX = 0;
    $minY = $height; $maxY = 0;
    $found = false;
    
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $rgb);
            // Black or very dark, completely opaque
            if ($colors['red'] < 10 && $colors['green'] < 10 && $colors['blue'] < 10 && $colors['alpha'] == 0) {
                // Ignore the very thin outer black lines of the drawing.
                // The rectangle is a solid block of black. We can just collect ALL black pixels
                // and maybe look for the densest block or just filter out lines by looking at neighbors.
                
                // Let's do a simple check: is it part of a 5x5 black block?
                $is_block = true;
                if ($x + 4 < $width && $y + 4 < $height) {
                    for ($dy = 0; $dy < 5; $dy++) {
                        for ($dx = 0; $dx < 5; $dx++) {
                            $c = imagecolorsforindex($img, imagecolorat($img, $x+$dx, $y+$dy));
                            if ($c['red'] > 20 || $c['alpha'] > 100) { $is_block = false; break 2; }
                        }
                    }
                } else {
                    $is_block = false;
                }
                
                if ($is_block) {
                    $found = true;
                    if ($x < $minX) $minX = $x;
                    if ($x > $maxX) $maxX = $x;
                    if ($y < $minY) $minY = $y;
                    if ($y > $maxY) $maxY = $y;
                }
            }
        }
    }
    
    if ($found) {
        // Adjust for the 5x5 block check offset
        $maxX += 4;
        $maxY += 4;
        $w = $maxX - $minX;
        $h = $maxY - $minY;
        $left_pct = ($minX / $width) * 100;
        $top_pct = ($minY / $height) * 100;
        $w_pct = ($w / $width) * 100;
        $h_pct = ($h / $height) * 100;
        return "$file: left={$left_pct}%, top={$top_pct}%, width={$w_pct}%, height={$h_pct}%\n";
    }
    return "$file: No block found\n";
}

$files = [
    "public/pictures/design/Label on the back.png",
    "public/pictures/design/Label on the back p1.png",
    "public/pictures/design/Inseam loop label.png",
    "public/pictures/design/Inseam loop label p1.png"
];

foreach ($files as $f) {
    echo get_black_rect(__DIR__ . '/../' . $f);
}
