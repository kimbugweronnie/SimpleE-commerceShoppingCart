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
    
    //all products
    public function mount()
    {

        $this->products = $this->getProducts();
    }
   
    //all product whose stock quantity in less than or equal to 5
    public function getProducts(): array
    {
        $products = Product::where('stock_quantity', '<=', 5)->get();

        return $products;

    }
}
