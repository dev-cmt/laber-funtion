<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a category
        $category = Category::firstOrCreate(
            ['name' => 'Electronics'],
            ['status' => 1]
        );

        // Ensure we have a brand
        $brand = Brand::firstOrCreate(
            ['name' => 'Generic Brand'],
            ['status' => 1]
        );

        $products = [
            [
                'name' => 'High Performance Headlight',
                'description' => 'Bright LED headlight for long-distance visibility.',
                'regular_price' => 450.00,
                'sale_price' => 399.00,
                'sku' => 'HL-LED-001',
            ],
            [
                'name' => 'Premium Brake Pads',
                'description' => 'Reliable and durable brake pads for all weather conditions.',
                'regular_price' => 120.00,
                'sale_price' => 99.00,
                'sku' => 'BP-PREM-002',
            ],
            [
                'name' => 'Sport Steering Wheel',
                'description' => 'Leather-wrapped steering wheel for a better grip and feel.',
                'regular_price' => 250.00,
                'sale_price' => 250.00, // No discount
                'sku' => 'SW-SPORT-003',
            ],
            [
                'name' => 'Advanced Oil Filter',
                'description' => 'High-efficiency oil filter for cleaner engine performance.',
                'regular_price' => 35.00,
                'sale_price' => 29.99,
                'sku' => 'OF-ADV-004',
            ],
            [
                'name' => 'All-Season Tires',
                'description' => 'Superior grip on both wet and dry roads.',
                'regular_price' => 600.00,
                'sale_price' => 549.00,
                'sku' => 'TR-AS-005',
            ],
            [
                'name' => 'Custom Seat Covers',
                'description' => 'Waterproof and easy to clean seat covers.',
                'regular_price' => 180.00,
                'sale_price' => 149.00,
                'sku' => 'SC-CUST-006',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['sku' => $p['sku']],
                array_merge($p, [
                    'slug' => Str::slug($p['name']),
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'purchase_price' => $p['regular_price'] * 0.7,
                    'stock_status' => 'in_stock',
                    'total_stock' => 50,
                    'status' => 1,
                    'visibility' => 'public',
                    'published_at' => now(),
                ])
            );
        }
    }
}
