<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_item_belongs_to_user()
    {
        // Arrange
        $user = User::factory()->create();

        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
        ]);

        $relatedUser = $cartItem->user;

        $this->assertInstanceOf(User::class, $relatedUser);
        $this->assertEquals($cartItem->user_id, $relatedUser->id);
    }

    public function test_cart_item_belongs_to_product()
    {
    
        $product = Product::factory()->create();

        $cartItem = CartItem::factory()->create([
            'product_id' => $product->id,
        ]);

        $relatedProduct = $cartItem->product;

        $this->assertInstanceOf(Product::class, $relatedProduct);
        $this->assertEquals($cartItem->product_id, $relatedProduct->id);
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

    public function test_it_gets_cart_item_by_product()
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

        $item = (new CartItem())->getCartItemByProduct($product->id);
        $this->assertEquals($product->id, $item->first()->product_id);
    }

    public function test_it_get_sub_total()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);


        $this->actingAs($user);

        $item = (new CartItem())->getSubTotal();
        $this->assertEquals(2000, $item);
    }

    public function test_it_adds_units()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        

        $this->actingAs($user);

        $item = (new CartItem())->addUnits($cartItem->id);
        $this->assertEquals(2, $item->first()->units);
    }

    public function test_it_adds_units_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        

        $this->actingAs($user);

        $item = (new CartItem())->addUnitsProduct($cartItem->product_id);
        $this->assertEquals(2, $item->first()->units);
    }


    public function test_it_lock_for_update_get()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        

        $this->actingAs($user);

        $items = (new CartItem())->lockForUpdateGet();
        $this->assertEquals(1, $items->first()->units);
    }

    public function test_it_update_bought_true()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => 1000,
            'units' => 1,
            'bought' => false,
        ]);
        

        $this->actingAs($user);

        $item = (new CartItem())->updateBuyTrue();
        $this->assertEquals(true, $item);
    }

    public function test_it_gets_unit_totals()
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
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'units' => 1,
            'bought' => false,
        ]);


        $this->actingAs($user);

        $item = (new CartItem())->getUnitTotal();
        $this->assertEquals(2, $item);
    }

    public function test_it_returns_only_unbought_items_for_authenticated_user()
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

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'units' => 1,
            'bought' => true,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'units' => 1,
            'bought' => false,
        ]);

        $this->actingAs($user);

        $items = (new CartItem())->getCartItems();

        $this->assertEquals($user->id, $items->first()->user_id);
    }
}
