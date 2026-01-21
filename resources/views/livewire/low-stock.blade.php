<div class="flex h-full w-full flex-1 flex-row gap-4 rounded-xl">
    <x-card>
        <x-heading size="lg" class="mb-4">
           These Product(s) are running Low
        </x-heading>
        <table class="w-full border-collapse text-sm">
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock_quantity }} left</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </x-card>

</div>
