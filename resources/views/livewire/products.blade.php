 <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
     <x-heading size="lg">Products</x-heading>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach($products as $product)
                <a class="" href="{{ route('product.show', $product) }}">
                    <x-card>
                        <x-heading size="lg"> {{$product->name}}</x-heading>

                        <x-text class="mt-2 mb-4">
                            $ {{ number_format($product->price, 2) }}
                        </x-text>

                        @if($product->stock_quantity == 1)
                        <x-text class="mt-2 mb-4">
                            {{$product->stock_quantity }} unit left
                        </x-text>
                        @endif

                        @if($product->stock_quantity < 1)
                        <x-text class="mt-2 mb-4">
                            Out of Stock
                        </x-text>
                        @endif

                        @if($product->stock_quantity > 1)
                        <x-text class="mt-2 mb-4">
                            {{$product->stock_quantity }} units left
                        </x-text>
                        @endif
                    </x-card>
                </a>
                

            @endforeach
            
        </div>
       
    </div>

