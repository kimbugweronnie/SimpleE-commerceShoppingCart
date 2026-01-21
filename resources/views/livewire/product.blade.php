
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <x-heading size="lg">{{ $product['name'] }}</x-heading>
    <x-card>
        <x-text class="mt-2 mb-4">
            $ {{ number_format($product['price'], 2) }}
        </x-text>

        @if($product['stock_quantity'] == 1)
        <x-text class="mt-2 mb-4">
            {{$product->stock_quantity }} unit left
        </x-text>
        @endif

        @if($product['stock_quantity'] < 1)
        <x-text class="mt-2 mb-4">
            Out of Stock
        </x-text>
        @endif

        @if($product['stock_quantity'] > 1)
        <x-text class="mt-2 mb-4">
            {{$product['stock_quantity'] }} units left
        </x-text>
        @endif
        @if($this->isadded == false)
            <x-button variant="secondary" wire:click="addToCart()">
                Add to Cart
            </x-button>
        @endif 
        @if($this->isadded == true)
            <div class="flex  flex-1 flex-row gap-4 rounded-xl">
                <x-button variant="secondary" wire:click="addUnits({{ $product['id'] }})">+</x-button>
                <x-text class="mt-2">{{ $units }}</x-text>
                <x-button variant="secondary" wire:click="subtractUnits({{ $product['id'] }})">-</x-button>
            </div>
         @endif          
    </x-card>
    
</div>

 
           


