<?php

/**
 * Download plant images from CDN for the seeder
 * Run this script: php download_plant_images.php
 */

$images = [
    // Indoor plants
    'monstera.jpg'         => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?auto=format&fit=crop&w=800&q=80',
    'snake-plant.jpg'      => 'https://images.unsplash.com/photo-1620127682229-33388276e540?auto=format&fit=crop&w=800&q=80',
    'pothos.jpg'           => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?auto=format&fit=crop&w=800&q=80',
    'peace-lily.jpg'       => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80',
    'fiddle-leaf-fig.jpg'  => 'https://images.unsplash.com/photo-1545241047-6083a3684587?auto=format&fit=crop&w=800&q=80',
    'rubber-plant.jpg'     => 'https://images.unsplash.com/photo-1519751138087-5bf79df62d5b?auto=format&fit=crop&w=800&q=80',
    'zz-plant.jpg'         => 'https://images.unsplash.com/photo-1592150621744-aca64f48394a?auto=format&fit=crop&w=800&q=80',
    'english-ivy.jpg'      => 'https://images.unsplash.com/photo-1516912481808-3406841bd33c?auto=format&fit=crop&w=800&q=80',
    'spider-plant.jpg'     => 'https://images.unsplash.com/photo-1584589167171-541ce45f1eea?auto=format&fit=crop&w=800&q=80',
    'boston-fern.jpg'      => 'https://images.unsplash.com/photo-1593482892290-f54927ae1bb6?auto=format&fit=crop&w=800&q=80',
    'bird-of-paradise.jpg' => 'https://images.unsplash.com/photo-1534430480872-3498386e7856?auto=format&fit=crop&w=800&q=80',
    'dracaena.jpg'         => 'https://images.unsplash.com/photo-1525498128493-380d1990a112?auto=format&fit=crop&w=800&q=80',
    'philodendron.jpg'     => 'https://images.unsplash.com/photo-1611211232932-da3113c5b960?auto=format&fit=crop&w=800&q=80',
    'bamboo-palm.jpg'      => 'https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=800&q=80',
    // Succulents
    'aloe-vera.jpg'        => 'https://images.unsplash.com/photo-1509937528035-ad76254b0356?auto=format&fit=crop&w=800&q=80',
    'echeveria.jpg'        => 'https://images.unsplash.com/photo-1509923952426-22e8c76bb2c5?auto=format&fit=crop&w=800&q=80',
    'jade-plant.jpg'       => 'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&w=800&q=80',
    'succulent-mix.jpg'    => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?auto=format&fit=crop&w=800&q=80',
    'desert-cactus.jpg'    => 'https://images.unsplash.com/photo-1543364195-bfe6e4932397?auto=format&fit=crop&w=800&q=80',
    // Flowering
    'orchid.jpg'           => 'https://images.unsplash.com/photo-1508610048659-a06b669e3321?auto=format&fit=crop&w=800&q=80',
    'garden-rose.jpg'      => 'https://images.unsplash.com/photo-1464820453369-31d2c0b651af?auto=format&fit=crop&w=800&q=80',
    // Palms & trees
    'tropical-palm.jpg'    => 'https://images.unsplash.com/photo-1612528443702-f6741f70a049?auto=format&fit=crop&w=800&q=80',
    'bonsai-tree.jpg'      => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
    // Herbs & foliage
    'herbal-basil.jpg'     => 'https://images.unsplash.com/photo-1560807707-8cc77767d783?auto=format&fit=crop&w=800&q=80',
    'fern-collection.jpg'  => 'https://images.unsplash.com/photo-1446329813274-7c9036bd9a1f?auto=format&fit=crop&w=800&q=80',
];

$targetDir = __DIR__ . '/public/images/plants';

// Create directory if it doesn't exist
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
    echo "Created directory: $targetDir\n";
}

echo "Downloading plant images...\n";

foreach ($images as $filename => $url) {
    $filepath = $targetDir . '/' . $filename;

    if (file_exists($filepath) && filesize($filepath) > 10000) {
        echo "✓ Skipping $filename (already exists)\n";
        continue;
    }

    echo "Downloading $filename...\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $imageData) {
        file_put_contents($filepath, $imageData);
        echo "✓ Downloaded $filename\n";
    } else {
        echo "✗ Failed to download $filename (HTTP: $httpCode)\n";
    }
}

echo "\nDownload complete!\n";
echo "Now run: php artisan db:seed --class=PlantSeederWithImages\n";
