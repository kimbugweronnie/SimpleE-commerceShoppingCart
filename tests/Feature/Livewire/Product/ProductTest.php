<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

   //Products are seeded already
    public function test_authenticated_users_can_visit_a_particular_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get(route('product.show', $product))
            ->assertOk();
    }
}
