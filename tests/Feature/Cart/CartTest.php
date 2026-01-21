<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class CartTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_authenticated_users_can_visit_see_cart(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/cart')->assertOk();
    }
}
