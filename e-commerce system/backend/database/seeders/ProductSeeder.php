<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch 10 fake products
        $response = Http::get('https://fakestoreapi.com/products?limit=10');

        if ($response->successful()) {
            $products = $response->json();

            foreach ($products as $item) {
                Product::create([
                    'name' => $item['title'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image_url' => $item['image'],
                ]);
            }

            $this->command->info('✅ 10 products successfully seeded from FakeStoreAPI!');
        } else {
            $this->command->error('❌ Failed to fetch data from FakeStoreAPI.');
        }
    }
}
