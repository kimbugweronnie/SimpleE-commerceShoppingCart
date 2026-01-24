<?php

namespace App\Livewire;

use App\Services\ActionLogService;
use App\Services\CartService;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems;

    public $units;

    public $totals;

   

    public function render()
    {
        return view('livewire.cart');
    }

    //cartItems, items units,total units 
    public function mount(CartService $cartService)
    {
        $this->cartItems = $cartService->getCartItems();
        $this->units = $cartService->getUnitTotal();
        $this->totals = $cartService->getSubTotal();

    }


    //adding additional units for  item added
    public function addUnits(int $id, CartService $cartService, ActionLogService $logger)
    {

        $cartService->addUnits($id, $logger);
        $this->dispatch('toast', message: 'Product added successfully');

        return redirect()->route('cart');
    }
    
    //reducing units for an item added
    public function subtractUnits(int $id, CartService $cartService, ActionLogService $logger)
    {
        $cartItem = $cartService->getCartItem($id);
        if ($cartItem->units == 1) {
            $cartService->removeFromCart($id, $logger);
            $this->dispatch('toast', message: 'Product removed from cart successfully');

            return redirect()->route('cart');
        }

        $cartService->subtractUnits($id, $logger);
        $this->dispatch('toast', message: 'Item quantity has been updated');

        return redirect()->route('cart');

    }

    //removing item from cart
    public function removeFromCart(int $id, CartService $cartService, ActionLogService $logger)
    {
        $cartItem = $cartService->removeFromCart($id, $logger);
        $this->dispatch('toast', message: 'Product removed from cart successfully');

        return redirect()->route('cart');

    }
   
    //checkout  function
    public function toCheckout(CartService $cartService, ActionLogService $logger)
    {

        $cartService->toCheckout($logger);
        $this->dispatch('toast', message: 'Purchase Successful');

        return redirect()->route('dashboard');
    }
}
