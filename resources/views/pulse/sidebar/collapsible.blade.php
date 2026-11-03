@props(['label', 'href' => null, 'current' => false, 'childActive' => false, 'icon' => null, 'svg' => null, 'view' => null])

@php
$rowClasses = 'group flex flex-1 items-center gap-3 rounded-full px-4 py-2 text-sm font-medium transition '
    . ($current
        ? 'bg-(--pulse-accent) text-(--pulse-accent-contrast)'
        : ($childActive
            ? 'bg-(--pulse-accent)/10 text-(--pulse-accent)'
            : 'text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-300) dark:hover:bg-(--pulse-neutral-800)'));

$iconClasses = 'h-5 w-5 shrink-0 '
    . ($current
        ? 'text-(--pulse-accent-contrast)'
        : ($childActive
            ? 'text-(--pulse-accent)'
            : 'text-(--pulse-neutral-400) group-hover:text-(--pulse-neutral-600) dark:group-hover:text-(--pulse-neutral-300)'));
@endphp

<div {{ $attributes->class('space-y-1') }} data-pulse-sidebar-group>
    <div class="flex items-center gap-1">
        @if ($href)
            <a href="{{ $href }}" class="{{ $rowClasses }}">
                @if ($icon || $svg || $view)
                    <x-pulse::icon name="{{ $icon }}" :svg="$svg" :view="$view" class="{{ $iconClasses }}" />
                @endif
                <span class="flex-1 truncate">{{ $label }}</span>
            </a>
            <button
                type="button"
                data-pulse-sidebar-group-toggle
                aria-expanded="false"
                class="shrink-0 rounded-full p-2 text-(--pulse-neutral-400) transition hover:bg-(--pulse-neutral-100) hover:text-(--pulse-neutral-600) dark:hover:bg-(--pulse-neutral-800) dark:hover:text-(--pulse-neutral-300)"
            >
                <x-pulse::icon name="chevron-down" data-pulse-sidebar-group-chevron class="h-4 w-4 transition-transform" />
            </button>
        @else
            <button type="button" data-pulse-sidebar-group-toggle aria-expanded="false" class="{{ $rowClasses }}">
                @if ($icon || $svg || $view)
                    <x-pulse::icon name="{{ $icon }}" :svg="$svg" :view="$view" class="{{ $iconClasses }}" />
                @endif
                <span class="flex-1 truncate text-left">{{ $label }}</span>
                <x-pulse::icon name="chevron-down" data-pulse-sidebar-group-chevron class="h-4 w-4 shrink-0 transition-transform" />
            </button>
        @endif
    </div>

    <div data-pulse-sidebar-group-panel class="hidden space-y-1">
        {{ $slot }}
    </div>
</div>
