<div class="flex h-full w-full flex-1 flex-row gap-4 rounded-xl">
    @if (count($cartItems) >= 1)
        <div class="w-2/3">
            <x-card>
                <x-heading size="lg" class="mb-4 px-3">
                    Cart({{ $units }})
                </x-heading>
                <table class="w-full border-collapse text-sm">
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr>
                                <td class="px-3">
                                    <a class=""
                                        href="{{ route('product.show', $cartItem['product']) }}">
                                        {{ $cartItem['product_name'] }}
                                    </a>
                                    <div class="mt-2 mb-4">
                                        <x-button variant="secondary" wire:click="removeFromCart({{ $cartItem['id'] }})">
                                            Remove
                                        </x-button>
                                    </div>
                                </td>
                                <td class="px-2">
                                    $ {{ number_format($cartItem['product_price'], 2) }}
                                    <div class="flex flex-1 flex-row gap-4 rounded-xl mt-2 mb-4">
                                        <x-button variant="secondary"
                                            wire:click="addUnits({{ $cartItem['id'] }})">+</x-button>
                                        <x-text class="mt-2">{{ $cartItem['units'] }}</x-text>
                                        <x-button variant="secondary"
                                            wire:click="subtractUnits({{ $cartItem['id'] }})">-</x-button>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </x-card>

        </div>
        <div class="w-1/3">
            <x-card>
                <x-heading size="lg" class="mb-4">
                    Cart Summary
                </x-heading>
                <x-text class="mt-2 mb-4">
                    Subtotal {{ $totals }}
                </x-text>
                <x-button variant="secondary" wire:click="toCheckout()">
                    Checkout<x-badge color="green">$ {{ number_format($totals, 2) }}</x-badge>
                </x-button>
            </x-card>
        </div>
    @else
        <x-heading size="lg" class="mb-4">
           Your cart is empty!
        </x-heading>
    @endif
</div>
