<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_authenticated_users_can_visit_see_products(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/dashboard')->assertOk();
    }
}
