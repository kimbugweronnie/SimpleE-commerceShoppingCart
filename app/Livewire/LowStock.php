<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class LowStock extends Component
{
    public $products;

    public function render()
    {
        return view('livewire.low-stock');
    }

    public function mount()
    {

        $this->products = $this->getProducts();
    }

    public function getProducts(): array
    {
        $products = Product::where('stock_quantity', '<=', 5)->get();

        return $products;

    }
}
