<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddToCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\Product::class, [
                'product' => $product,
            ])
            ->call('addToCart')
            ->assertDispatched('toast')
            ->assertRedirect('/product/'.$product['slug']);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'bought' => false,
            'units' => 1,
        ]);
    }
}
