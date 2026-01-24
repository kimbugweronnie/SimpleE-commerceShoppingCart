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
   
    // specific product,product units,check if product is added(boolean)
    public function mount($product, ProductService $productService)
    {
        $this->product = $product;
        $this->units = $this->getUnits();
        $this->isadded = $productService->checkCartItem($product->id);

    }
    // add to cart functionality
    public function addToCart(ProductService $productService, ActionLogService $logger)
    {

        $item = $productService->addToCart(1, $this->product['name'], $this->product['id'], auth()->user()->id, $this->product['price']);
        //action is stored 
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
  
    //fetch cart item based on product id
    private function getCartItem()
    {
        return CartItem::where('product_id', $this->product->id)->where('user_id', auth()->user()->id)->where('bought', false)->first();

    }
   
    //cartItem units
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
    //adding additional units for  item added
    public function addUnits(int $id, CartService $cartService, ActionLogService $logger)
    {

        $cartService->addUnitsProduct($id, $logger);
        $this->dispatch('toast', message: 'Product added successfully');

        return redirect()->route('product.show', $this->product);
    }
   
    //reducing units for an item added
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

}
