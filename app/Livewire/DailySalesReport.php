<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DailySalesReport extends Component
{
    public $sales;

    public function render()
    {
        return view('livewire.daily-sales-report');
    }

    public function mount()
    {
        $this->sales = $this->getSales();

    }
   // all the sales based on product name for the current date
    public function getSales()
    {
        $date = now()->toDateString();

        $sales = DB::table('cart_items')
            ->where('bought', true)
            ->whereDate('created_at', $date)
            ->select(
                'product_name',
                DB::raw('SUM(units) as total_units'),
                DB::raw('SUM(units * product_price) as total_revenue')
            )
            ->groupBy('product_name')
            ->get();

        if ($sales->isEmpty()) {
            return;
        }
    }
}
