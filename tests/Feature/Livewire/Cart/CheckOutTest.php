<!-- <?php

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CheckOutTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_to_checkout_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\Cart::class)
            ->call('toCheckout');

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'units' => 1,
        ]);
        

        
    }
}
