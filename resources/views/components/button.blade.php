@props(['variant' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
    ];
@endphp

<button
    {{ $attributes->merge([
        'class' => 'px-4 py-2 rounded-md font-medium transition ' . ($variants[$variant] ?? $variants['primary'])
    ]) }}
>
    {{ $slot }}
</button>
