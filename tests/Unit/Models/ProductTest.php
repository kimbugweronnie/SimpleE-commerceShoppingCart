<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;


    public function test_product_has_many_cart_items()
    {
        $product = Product::factory()->create();

        $cartItems = CartItem::factory()->count(3)->create([
            'product_id' => $product->id,
        ]);

        $result = $product->cartItems;

        $this->assertCount(3, $result);
    }

    public function test_it_adds_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'units' => 1,
            'bought' => false,
        ]);


        $this->actingAs($user);

        $item = (new CartItem())->addToCart(1,$product->name,$product->id,$user->id,$product->price);
        $this->assertEquals($user->id, $item->first()->user_id);
    }

    public function test_it_gets_product_by_id()
    {
       
        $product = Product::create([
            'id' => 1,
            'name' => "test",
            'price' => 1000,
            'stock_quantity' => 100
        ]);

        $item = (new Product())->getProduct($product->id);
        $this->assertEquals($product->id, $item->first()->id);
    }
    public function test_it_lock_for_update_get()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => "test",
            'price' => 1000,
            'stock_quantity' => 100
        ]);

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        
        
        $item = (new Product())->lockForUpdateProduct($cartItem);
        $this->assertEquals(100, $product->first()->stock_quantity);
    }


    
   


    

   

    

  
}
