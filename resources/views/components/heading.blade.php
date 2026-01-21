@props(['size' => 'md'])

@php
    $sizes = [
        'sm' => 'text-sm font-semibold',
        'md' => 'text-base font-semibold',
        'lg' => 'text-lg font-bold',
        'xl' => 'text-xl font-bold',
    ];
@endphp

<h2 {{ $attributes->merge([
    'class' => $sizes[$size] ?? $sizes['md']
]) }}>
    {{ $slot }}
</h2>
