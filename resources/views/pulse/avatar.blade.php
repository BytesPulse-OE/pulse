@props(['photo' => null, 'fallback' => null, 'alt' => '', 'size' => 'h-9 w-9'])

@if ($photo)
    <img
        src="{{ $photo }}"
        alt="{{ $alt }}"
        {{ $attributes->class("$size shrink-0 rounded-full object-cover") }}
    >
@else
    <span
        {{ $attributes->class("$size shrink-0 flex items-center justify-center rounded-full bg-(--pulse-accent) text-xs font-semibold uppercase text-(--pulse-accent-contrast)") }}
    >
        {{ $fallback }}
    </span>
@endif
