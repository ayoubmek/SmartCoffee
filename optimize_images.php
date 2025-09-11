<?php
require __DIR__ . '/vendor/autoload.php';

use Spatie\ImageOptimizer\OptimizerChainFactory;

// Path to your images folder
$imagesFolder = __DIR__ . '/public/assets/media/ch';

// Get all jpg and png images in the folder
$images = glob($imagesFolder . '/*.{jpg,jpeg,png}', GLOB_BRACE);

$optimizerChain = OptimizerChainFactory::create();

foreach ($images as $image) {
    try {
        $optimizerChain->optimize($image);
        echo "Optimized: $image\n";
    } catch (\Exception $e) {
        echo "Failed: $image -> " . $e->getMessage() . "\n";
    }
}

echo "Done!";
