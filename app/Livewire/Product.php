<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Services\ActionLogService;
use App\Services\CartService;
use App\Services\ProductService;
use Livewire\Component;

class Product extends Component
{
    public $product;

    public $isadded;

    public $units;

    public function render()
    {
        return view('livewire.product');
    }

    public function mount($product, ProductService $productService)
    {
        $this->product = $product;
        $this->units = $this->getUnits();
        $this->isadded = $productService->checkCartItem($product->id);

    }

    public function addToCart(ProductService $productService, ActionLogService $logger)
    {

        $item = $productService->addToCart(1, $this->product['name'], $this->product['id'], auth()->user()->id, $this->product['price']);
        $logger->log(
            auth()->user()->id,
            'add to cart',
            CartItem::class,
            $item->id,
            ['action' => auth()->user()->name.' added '.$item->product_name.' to cart at '.$item->created_at->format('Y-m-d H:i:s')]
        );

        $this->dispatch('toast', message: 'Product added to cart  🛒');

        return redirect()->route('product.show', $this->product);
    }

    private function getCartItem()
    {
        return CartItem::where('product_id', $this->product->id)->where('user_id', auth()->user()->id)->where('bought', false)->first();

    }

    public function getUnits()
    {
        $cartItem = $this->getCartItem();
        if ($cartItem == null) {
            return;
        } else {
            return $cartItem->units;
        }
    }

    public function checkCartItem(): bool
    {
        $cartItem = $this->getCartItem();
        if ($cartItem == null) {
            return false;
        } else {
            return true;
        }
    }

    public function addUnits(int $id, CartService $cartService, ActionLogService $logger)
    {

        $cartService->addUnitsProduct($id, $logger);
        $this->dispatch('toast', message: 'Product added successfully');

        return redirect()->route('product.show', $this->product);
    }

    public function subtractUnits(int $id, CartService $cartService, ActionLogService $logger)
    {
        $cartItem = $cartService->getCartItemByProduct($id);
        if ($cartItem->units == 1) {
            $cartService->removeFromCartByProduct($id, $logger);
            $this->dispatch('toast', message: 'Product removed from cart successfully');

            return redirect()->route('product.show', $this->product);
        }

        $cartService->subtractUnitsProduct($id, $logger);
        $this->dispatch('toast', message: 'Item quantity has been updated');

        return redirect()->route('product.show', $this->product);

    }

    // public function removeFromCart(int $id,CartService $cartService,ActionLogService $logger){
    //     $cartItem = $cartService->removeFromCart($id,$logger);
    //     $this->dispatch('toast', message: 'Product removed from cart successfully');
    //     return redirect()->route('cart');

    // }

}
