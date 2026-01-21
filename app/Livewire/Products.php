<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class Products extends Component
{
    public $products = [];

    public function render()
    {
        return view('livewire.products');
    }

    public function mount()
    {
        $this->products = $this->getProducts();
    }

    private function getProducts(): Collection
    {

        return Product::where('stock_quantity', '>', 0)->get();
    }
}
