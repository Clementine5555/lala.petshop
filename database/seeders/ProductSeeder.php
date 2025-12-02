<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_id' => 1,
                'name' => 'Whiskas',
                'description' => 'Makanan lezat dan bergizi untuk kucing kesayangan Anda',
                'price' => 130000,
                'stock' => 15,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'whiskas.avif',
            ],
            [
                'product_id' => 2,
                'name' => 'Me-O',
                'description' => 'Premium cat food with salmon',
                'price' => 99000,
                'stock' => 30,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'me-o.jpg',
            ],
            [
                'product_id' => 3,
                'name' => 'Royal Canin',
                'description' => 'High quality pet nutrition',
                'price' => 99000,
                'stock' => 20,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'catDog.jpg',
            ],
            [
                'product_id' => 4,
                'name' => 'Cat Choize',
                'description' => 'Makanan kucing berkualitas tinggi',
                'price' => 210000,
                'stock' => 18,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'catchoize.jpeg',
            ],
            [
                'product_id' => 5,
                'name' => 'Premium Dry Dog Food',
                'description' => 'Nutrisi lengkap untuk anjing dewasa, 5kg',
                'price' => 350000,
                'stock' => 12,
                'category' => 'Dog Food',
                'supplier_id' => null,
                'image' => 'premiumdry.webp',
            ],
            [
                'product_id' => 6,
                'name' => 'Pedigree Adult',
                'description' => 'Complete nutrition for adult dogs',
                'price' => 285000,
                'stock' => 25,
                'category' => 'Dog Food',
                'supplier_id' => null,
                'image' => 'pedigree.jpg',
            ],
            [
                'product_id' => 7,
                'name' => 'Purina Pro Plan',
                'description' => 'Advanced nutrition for cats',
                'price' => 425000,
                'stock' => 8,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'purina.jpeg',
            ],
            [
                'product_id' => 8,
                'name' => 'Friskies',
                'description' => 'Delicious meals for playful cats',
                'price' => 75000,
                'stock' => 40,
                'category' => 'Cat Food',
                'supplier_id' => null,
                'image' => 'friskies.avif',
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['product_id' => $product['product_id']],
                $product
            );
        }
    }
}
