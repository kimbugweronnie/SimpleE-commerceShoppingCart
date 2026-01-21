@props(['header' => false])

@if ($header)
    <th class="py-2 text-left font-medium">
        {{ $slot }}
    </th>
@else
    <td class="py-3">
        {{ $slot }}
    </td>
@endif
