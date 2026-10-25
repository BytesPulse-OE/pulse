@props(['variant' => 'primary', 'type' => 'submit', 'icon' => null, 'iconOnly' => false, 'loading' => false])

@php
$colorClasses = match ($variant) {
    'secondary' => 'bg-(--pulse-neutral-100) text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-200) dark:bg-(--pulse-neutral-800) dark:text-(--pulse-neutral-100) dark:hover:bg-(--pulse-neutral-700)',
    'danger' => 'bg-red-500 text-white hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500',
    default => 'bg-(--pulse-accent) text-(--pulse-accent-contrast) hover:brightness-110',
};

$sizing = $iconOnly ? 'p-2' : 'px-5 py-2';
$classes = "pulse-button inline-flex items-center justify-center gap-2 align-middle shrink-0 whitespace-nowrap rounded-full $sizing text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-(--pulse-accent) disabled:opacity-50 $colorClasses";
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->class($classes) }}>
        @if ($icon)
            <x-pulse::icon name="{{ $icon }}" class="h-4 w-4" />
        @endif
        @unless ($iconOnly)
            {{ $slot }}
        @endunless
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class($classes)->merge(['disabled' => $loading]) }}
        @if ($loading) data-pulse-loading @endif
    >
        <svg class="pulse-button-spinner h-4 w-4 animate-spin {{ $loading ? '' : 'hidden' }}" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M12 2a10 10 0 0 1 10 10h-4a6 6 0 0 0-6-6V2z"></path>
        </svg>
        @if ($icon)
            <x-pulse::icon name="{{ $icon }}" class="pulse-button-icon h-4 w-4 {{ $loading ? 'hidden' : '' }}" />
        @endif
        @unless ($iconOnly)
            <span class="pulse-button-label">{{ $slot }}</span>
        @endunless
    </button>
@endif
