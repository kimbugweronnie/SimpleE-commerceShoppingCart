<?php

namespace App\Livewire;

use App\Models\CartItem;
use Livewire\Component;

class CartNumber extends Component
{
    public $unitTotal;

    public function render()
    {
        return view('livewire.cart-number');
    }

    public function mount()
    {
        $this->unitTotal = $this->getUnitTotal();

    }

    public function getUnitTotal(): int
    {
        return CartItem::where('user_id', auth()->user()->id)->where('bought', false)->sum('units');
    }
}
