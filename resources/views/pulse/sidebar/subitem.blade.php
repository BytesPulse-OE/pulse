@props(['href' => '#', 'current' => false, 'icon' => null, 'svg' => null, 'view' => null])

<a
    href="{{ $href }}"
    {{ $attributes->class(
        'group flex items-center gap-3 rounded-full py-1.5 pl-10 pr-4 text-sm font-medium transition '
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
            class="h-4 w-4 shrink-0 {{ $current ? 'text-(--pulse-accent-contrast)' : 'text-(--pulse-neutral-400) group-hover:text-(--pulse-neutral-600) dark:group-hover:text-(--pulse-neutral-300)' }}"
        />
    @endif

    <span class="flex-1 truncate">{{ $slot }}</span>
</a>
