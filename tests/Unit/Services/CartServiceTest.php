<?php

namespace Tests\Unit\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\ActionLogService;
use App\Jobs\LowStockNotification;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;

use Mockery;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_cart_items_from_model()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

        $fakeItem = new CartItem;

        $fakeItem->forceFill(['id' => 1, 'user_id' => 10, 'units' => 2]);
       
        $fakeItems = collect([$fakeItem]);

        $mockCartItem
            ->shouldReceive('getCartItems')
            ->once()
            ->andReturn($fakeItems);

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getCartItems();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(1, $result->count());
    }

    public function test_it_returns_cart_item_from_model()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

        $fakeItem = new CartItem([
            'id' => 1,
            'user_id' => 10,
            'units' => 2,
        ]);
        $mockCartItem
            ->shouldReceive('getCartItem')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);
        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getCartItem(1);

        $this->assertInstanceOf(CartItem::class, $result);
        $this->assertEquals(2, $result->units);

    }

    public function test_it_returns_cart_item_from_model_by_product_id()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

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
        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getCartItemByProduct(1);

        $this->assertInstanceOf(CartItem::class, $result);
        $this->assertEquals(2, $result->units);

    }

    public function test_it_returns_product_by_id()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

        $fakeProduct = new Product([
            'id' => 1,
            'slug' => 'test',
            'name' => 'test',
            'price' => 200,
            'stock_quantity' => 100,
        ]);
        $mockCartItem
            ->shouldReceive('getProduct')
            ->once()
            ->with(1)
            ->andReturn($fakeProduct);
        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getProduct(1);

        $this->assertInstanceOf(Product::class, $result);

    }

    public function test_it_returns_unit_totals()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

        $fakeItems = collect([
            (object) ['id' => 1, 'user_id' => 10, 'units' => 2], ['id' => 2, 'user_id' => 10, 'units' => 2],
        ]);

        $mockCartItem
            ->shouldReceive('getUnitTotal')
            ->once()
            ->with()
            ->andReturn(4);
        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getUnitTotal();

        $this->assertIsInt($result);
        $this->assertEquals(4, $result);

    }

    public function test_it_returns_sub_totals()
    {
        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);

        $fakeItems = collect([
            (object) ['id' => 1, 'user_id' => 10, 'units' => 2, 'price' => 100], ['id' => 2, 'user_id' => 10, 'units' => 2, 'price' => 200],
        ]);

        $mockCartItem
            ->shouldReceive('getSubTotal')
            ->once()
            ->with()
            ->andReturn(600);
        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->getSubTotal();

        $this->assertIsInt($result);
        $this->assertEquals(600, $result);

    }

    public function test_it_remove_from_cart()
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
            ->shouldReceive('getCartItem')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

        $mockCartItem
            ->shouldReceive('removeFromCart')
            ->once()
            ->with(1)
            ->andReturnNull();

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'removed item from cart',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->removeFromCart(1, $mockLogger);
        $this->assertNull($result);

    }

    public function test_it_removes_from_cart_by_product()
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
            ->shouldReceive('getCartItemByProduct')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

        $mockCartItem
            ->shouldReceive('removeFromCartByProduct')
            ->once()
            ->with(1)
            ->andReturnNull();

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'removed item from cart',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->removeFromCartByProduct(1, $mockLogger);
        $this->assertNull($result);

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

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'add extra units',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->addUnits(1, $mockLogger);
        $this->assertInstanceOf(CartItem::class, $fakeItem);

    }

    public function test_it_adds_units_for_products()
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
            ->shouldReceive('addUnitsProduct')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'add extra units',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->addUnitsProduct(1, $mockLogger);
        $this->assertInstanceOf(CartItem::class, $fakeItem);

    }

    public function test_it_decreases_units_for_products()
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
            ->shouldReceive('subtractUnitsProduct')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'reduce units',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->subtractUnitsProduct(1, $mockLogger);
        $this->assertInstanceOf(CartItem::class, $fakeItem);

    }

    public function test_it_reduces_units()
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
            ->shouldReceive('subtractUnits')
            ->once()
            ->with(1)
            ->andReturn($fakeItem);

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'reduce units',
                CartItem::class,
                $fakeItem->id,
                Mockery::type('array')
            );

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->subtractUnits(1, $mockLogger);
        $this->assertInstanceOf(CartItem::class, $fakeItem);

    }

    public function test_it_checkout_items_and_email()
    {
        Queue::fake();

        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);
        $mockLogger = Mockery::mock(ActionLogService::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = new Product;
        $product->forceFill([
            'id' => 10,
            'stock_quantity' => 5,
        ]);

        $cartItem = new CartItem;
        $cartItem->forceFill([
            'id' => 1,
            'user_id' => $user->id,
            'units' => 2,
            'product_id' => 1,
            'product_name' => 'test',
        ]);
        $cartItem->setUpdatedAt(now());

        $cartItems = collect([$cartItem]);

        $mockCartItem
            ->shouldReceive('lockForUpdateGet')
            ->once()
            ->with()
            ->andReturn($cartItems);

        $mockProduct
            ->shouldReceive('lockForUpdateProduct')
            ->once()
            ->with($cartItem)
            ->andReturn($product);

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'reduce units',
                CartItem::class,
                $cartItem->id,
                Mockery::type('array')
            );
        $mockCartItem
            ->shouldReceive('updateBuyTrue')
            ->once()
            ->with()
            ->andReturn($cartItem);

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->toCheckout($mockLogger);

        Queue::assertPushed(LowStockNotification::class);

    }

    public function test_it_checkout_items_and_email_not_sent()
    {
        Queue::fake();

        $mockCartItem = Mockery::mock(CartItem::class);
        $mockProduct = Mockery::mock(Product::class);
        $mockLogger = Mockery::mock(ActionLogService::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = new Product;

        $product->forceFill([
            'id' => 1,
            'stock_quantity' => 100,
        ]);

        $cartItem = new CartItem;
        $cartItem->forceFill([
            'id' => 1,
            'user_id' => $user->id,
            'units' => 2,
            'product_id' => 1,
            'product_name' => 'test',
        ]);
        $cartItem->setUpdatedAt(now());

        $cartItems = collect([$cartItem]);
        $mockCartItem
            ->shouldReceive('lockForUpdateGet')
            ->once()
            ->with()
            ->andReturn($cartItems);

        $mockProduct
            ->shouldReceive('lockForUpdateProduct')
            ->once()
            ->with($cartItem)
            ->andReturn($product);

        $mockLogger
            ->shouldReceive('log')
            ->once()
            ->with(
                $user->id,
                'reduce units',
                CartItem::class,
                $cartItem->id,
                Mockery::type('array')
            );
        $mockCartItem
            ->shouldReceive('updateBuyTrue')
            ->once()
            ->with()
            ->andReturn($cartItem);

        $service = new CartService($mockCartItem, $mockProduct);

        $result = $service->toCheckout($mockLogger);

        Queue::assertNotPushed(LowStockNotification::class);

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
