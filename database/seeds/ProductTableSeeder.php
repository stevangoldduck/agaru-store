<?php

use App\Product;
use App\ProductCategory;
use Illuminate\Database\Seeder;


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'  => "Tonkat Baton",
            'category_id' => 1,
            'ean_number' => rand(pow(10, 13-1), pow(10, 13)-1),
            'ean_number_img_path'  => '/storage/public/ean/20200602_ean.png',
            'price' => 75000
        ]);

        ProductCategory::create([
            'name' => 'Keamanan',
            'slug' => 'keamanan'
        ]);
    }
}
