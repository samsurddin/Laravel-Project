@props(['status'])

@php
    $color = match ($status) {
        "active" => 'bg-green-100 text-green-800',
        default => 'bg-red-100 text-red-800',
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
    {{ ucfirst($status) }}
</span>