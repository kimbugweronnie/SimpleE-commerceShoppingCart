<!-- <?php

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RemoveFromCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_removed_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'units' => 1,
            'bought' => false,
        ]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\Cart::class)
            ->call('removeFromCart', $cartItem->id);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'units' => 1,
        ]);
        

        
    }
}
