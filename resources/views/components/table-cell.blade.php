@props(['header' => false])

@if ($header)
    <th class="px-4 py-2 text-left font-semibold text-gray-700">
        {{ $slot }}
    </th>
@else
    <td class="px-1 py-2">
        {{ $slot }}
    </td>
@endif
