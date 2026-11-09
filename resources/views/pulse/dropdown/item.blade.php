@props(['href' => null, 'type' => null, 'current' => false, 'icon' => null, 'svg' => null, 'view' => null])

@php
$classes = 'flex w-full items-center gap-2 px-4 py-2 text-left text-sm transition '
    . ($current
        ? 'bg-(--pulse-accent)/10 text-(--pulse-accent)'
        : 'text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-300) dark:hover:bg-(--pulse-neutral-800)');
$iconClasses = 'h-4 w-4 shrink-0 ' . ($current ? 'text-(--pulse-accent)' : 'text-(--pulse-neutral-400)');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }} data-pulse-dropdown-item>
        @if ($icon || $svg || $view)
            <x-pulse::icon name="{{ $icon }}" :svg="$svg" :view="$view" class="{{ $iconClasses }}" />
        @endif
        <span class="truncate">{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->class($classes) }} data-pulse-dropdown-item>
        @if ($icon || $svg || $view)
            <x-pulse::icon name="{{ $icon }}" :svg="$svg" :view="$view" class="{{ $iconClasses }}" />
        @endif
        <span class="truncate">{{ $slot }}</span>
    </button>
@endif
