@props(['href' => '#', 'current' => false, 'icon' => null, 'svg' => null, 'view' => null, 'badge' => false])

<a
    href="{{ $href }}"
    {{ $attributes->class(
        'group flex items-center gap-3 rounded-full px-4 py-2 text-sm font-medium transition '
        . ($current
            ? 'bg-(--pulse-accent) text-(--pulse-accent-contrast)'
            : 'text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-300) dark:hover:bg-(--pulse-neutral-800)')
    ) }}
>
    @if ($icon || $svg || $view)
        <x-pulse::icon
            name="{{ $icon }}"
            :svg="$svg"
            :view="$view"
            class="h-5 w-5 shrink-0 {{ $current ? 'text-(--pulse-accent-contrast)' : 'text-(--pulse-neutral-400) group-hover:text-(--pulse-neutral-600) dark:group-hover:text-(--pulse-neutral-300)' }}"
        />
    @endif

    <span class="flex-1 truncate">{{ $slot }}</span>

    @if ($badge)
        <span class="h-2 w-2 shrink-0 rounded-full bg-(--pulse-accent) {{ $current ? 'bg-(--pulse-accent-contrast)' : '' }}"></span>
    @endif
</a>
