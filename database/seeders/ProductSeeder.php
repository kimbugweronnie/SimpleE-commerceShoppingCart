<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product1 = Product::create(
            ['id' => 1,"slug" => 'Bravo 32 Inch Frameless Black', "name" => 'Bravo 32 Inch Frameless AC/DC Digital HD LED TV (Free To Air) Black','price' => 300, "stock_quantity" => 6],
           
        );
        $product2 = Product::create(
            ['id' => 2, "slug" => 'Samsung Galaxy A16 4G 6.7', "name" => 'Samsung Galaxy A16 4G 6.7" 4GB RAM 128GB ROM 50MP 5000mAh - Blue Black','price' => 300, "stock_quantity" => 100],
            
        );
        $product3 = Product::create(
            ['id' => 3,"slug" => 'Samsung Galaxy S22 Ultra 5G', "name" => 'Samsung Galaxy S22 Ultra 5G 12GB RAM 256GB ROM 5000MAH Battery-Burgundy','price' => 400, "stock_quantity" => 100]
        );
        $product4 = Product::create(
            ['id' => 4,"slug" => 'RENEWED Google Pixel 6a',"name" => 'RENEWED Google Pixel 6a 128GB ROM 8GB RAM - Green','price' => 300, "stock_quantity" => 100]
        );
        $product5 = Product::create(
            ['id' => 5,"slug" => 'RENEWED Latitude 11 Inch 3180 or 3190', "name" => 'RENEWED Latitude 11 Inch 3180/3190 4GB RAM 128GB SSD Refurbished - Grey/Black Grade A',"price" => 300, "stock_quantity" => 100],
           
        );
        $product6 = Product::create(
            ['id' => 6,"slug" => 'Epson Genuine L3252 Wireless Ink', "name" => 'Epson Genuine L3252 Wireless Ink Tank Printer All In One-Black',"price" => 300, "stock_quantity" => 100],
           
        );
        $product7 = Product::create(
            ['id' => 7,"slug" => 'GtyGo 128 GB OTG Usb', "name" => 'GtyGo 128 GB OTG Usb Flash Drive USB3.0 Adapter Type C 3 Units In 1 Set',"price" => 300, "stock_quantity" => 30],
           
        );
        $product8 = Product::create(
            ['id' => 9,"slug" => 'Toshiba 320 GB External Hard Disk Drive', "name" => 'Toshiba 320 GB External Hard Disk Drive - Black color',"price" => 300, "stock_quantity" => 50],
           
        );
        $product10 = Product::create(
            ['id' => 10,"slug" => 'STY 15.6" Notebook Computer Bag', "name" => 'STY 15.6" Notebook Computer Bag Men Business Backpack Rucksacks - Grey',"price" => 300, "stock_quantity" => 65],
           
        );
        $product11 = Product::create(
            ['id' => 11,"slug" => 'Casio Classic Red Dial Quartz Wristwatch', "name" => 'Casio Classic Red Dial Quartz Wristwatch Gold Stainless Steel Strap,Date Display, Classic Casual Dress Watch',"price" => 300, "stock_quantity" => 100],
           
        );
    }
}
