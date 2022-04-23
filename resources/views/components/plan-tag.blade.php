@props(['plan_id', 'plan_name'])

@php
    $plan_color = match ($plan_id) {
        "1" => 'bg-green-100 text-green-800',
        "2" => 'bg-amber-100 text-amber-800',
        "3" => 'bg-blue-100 text-blue-800',
        "4" => 'bg-teal-100 text-teal-800',
        "5" => 'bg-purple-100 text-purple-800',
        "6" => 'bg-pink-100 text-pink-800',
        "7" => 'bg-gray-100 text-gray-800',
        default => 'bg-red-100 text-red-800',
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{$plan_color}}">
    <a href="{{ route('plans.show', [app()->getLocale(), $plan_id]) }}">{{ $plan_name }}</a>
</span>