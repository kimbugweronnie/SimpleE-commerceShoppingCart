<?php

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddUnitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_units_are_incremented_if_item_exists()
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

        Livewire::actingAs($user)
            ->test(\App\Livewire\Product::class, ['product' => $product])
            ->call('addUnits', $product->id);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'units' => 2,
        ]);
    }
}
