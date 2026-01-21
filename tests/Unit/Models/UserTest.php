<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\CartItem;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_cart_items()
    {
        $user = User::factory()->create();

        $cartItems = CartItem::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $result = $user->cartItems;

        $this->assertCount(3, $result);
    }
}
