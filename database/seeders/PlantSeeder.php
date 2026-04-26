<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plants = [
            [
                'name' => 'Rose',
                'description' => 'Beautiful red roses perfect for gardens and bouquets. Easy to grow with proper care.',
                'price' => 29.99,
                'stock_count' => 50,
                'category' => 'flowers',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Tulip',
                'description' => 'Colorful spring flowers that brighten any garden. Available in multiple colors.',
                'price' => 19.99,
                'stock_count' => 75,
                'category' => 'flowers',
                'is_seasonal' => true,
                'season' => 'spring',
            ],
            [
                'name' => 'Monstera Deliciosa',
                'description' => 'Popular indoor plant with beautiful split leaves. Easy to care for and grows well indoors.',
                'price' => 89.99,
                'stock_count' => 15,
                'category' => 'indoor',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Snake Plant',
                'description' => 'Hardy indoor plant that purifies air. Perfect for beginners and low-light conditions.',
                'price' => 34.99,
                'stock_count' => 30,
                'category' => 'indoor',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Lavender',
                'description' => 'Fragrant herb with beautiful purple flowers. Great for aromatherapy and cooking.',
                'price' => 24.99,
                'stock_count' => 60,
                'category' => 'herbs',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Tomato Plant',
                'description' => 'Fresh tomato plants for your vegetable garden. Produces juicy tomatoes all summer.',
                'price' => 12.99,
                'stock_count' => 100,
                'category' => 'vegetables',
                'is_seasonal' => true,
                'season' => 'summer',
            ],
            [
                'name' => 'Sunflower',
                'description' => 'Tall, cheerful sunflowers that follow the sun. Perfect for summer gardens.',
                'price' => 15.99,
                'stock_count' => 45,
                'category' => 'flowers',
                'is_seasonal' => true,
                'season' => 'summer',
            ],
            [
                'name' => 'Aloe Vera',
                'description' => 'Medicinal succulent known for its healing properties. Easy to care for indoors.',
                'price' => 22.99,
                'stock_count' => 40,
                'category' => 'succulents',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Oak Tree Sapling',
                'description' => 'Young oak tree that will grow into a majestic shade tree. Great for large yards.',
                'price' => 149.99,
                'stock_count' => 8,
                'category' => 'trees',
                'is_seasonal' => false,
                'season' => null,
            ],
            [
                'name' => 'Basil',
                'description' => 'Aromatic herb essential for cooking. Easy to grow in pots or gardens.',
                'price' => 9.99,
                'stock_count' => 80,
                'category' => 'herbs',
                'is_seasonal' => false,
                'season' => null,
            ],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }
    }
}
