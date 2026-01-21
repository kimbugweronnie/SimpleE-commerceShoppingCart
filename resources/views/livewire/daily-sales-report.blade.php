<div class="flex h-full w-full flex-1 flex-row gap-4 rounded-xl">
    <x-card>
        <x-heading size="lg" class="mb-4">
            Daily Sales Report ({{ $date }})
        </x-heading>
        <table class="w-full border-collapse text-sm">
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->total_units }}</td>
                        <td>${{ number_format($sale->total_revenue, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </x-card>

</div>
