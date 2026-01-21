@props([
    'color' => 'gray'
])

@php
$colors = [
    'gray' => 'bg-gray-100 text-gray-800',
    'lime' => 'bg-lime-100 text-lime-800',
    'green' => 'bg-green-100 text-green-800',
];
@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full px-1 py-0.5 text-xl font-medium ' . ($colors[$color] ?? $colors['gray'])
    ]) }}
>
    {{ $slot }}
</span>
