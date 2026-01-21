<?php

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\ActionLogService;
use App\Jobs\LowStockNotification;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_gets_item()
    {
        $mockCartItem = \Mockery::mock(CartItem::class);
        $mockProduct = \Mockery::mock(Product::class);

        $fakeItem = new CartItem([
            'id' => 1,
            'user_id' => 10,
            'units' => 2,
            'product_id' => 1,
        ]);
        $mockCartItem
            ->shouldReceive('getCartItemByProduct')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);
        $service = new ProductService($mockCartItem, $mockProduct);

        $result = $service->getCartItem(1);

        $this->assertInstanceOf(CartItem::class, $result);
        $this->assertEquals(2, $result->units);
    }


    public function test_it_adds_to_cart()
    {
        $mockCartItem = \Mockery::mock(CartItem::class);
        $mockProduct = \Mockery::mock(Product::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $fakeItem = new CartItem([
            'id' => 1,
            'user_id' => $user->id,
            'units' => 2,
            'product_id' => 1,
        ]);
        $mockCartItem
            ->shouldReceive('addToCart')
            ->once()
            ->with(2,"test",1,$user->id,100)
            ->andReturn($fakeItem);

        $service = new ProductService($mockCartItem, $mockProduct);

        $result = $service->addToCart(2,"test",1,$user->id,100);

        $this->assertInstanceOf(CartItem::class, $result);
        $this->assertEquals(2, $result->units);
    }

    public function test_it_adds_units()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);
        $mockLogger = Mockery::mock(ActionLogService::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $fakeItem = new CartItem;
        $fakeItem->forceFill([
            'id' => 1,
            'user_id' => $user->id,
            'units' => 2,
            'product_id' => 1,
            'product_name' => 'test',
        ]);
        $fakeItem->setUpdatedAt(now());

        $mockCartItem
            ->shouldReceive('addUnits')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

       

        $service = new ProductService($mockCartItem, $mockProduct);

        $result = $service->addUnits(1);
        $this->assertInstanceOf(CartItem::class, $fakeItem);

    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }


}