@props(['href' => '#', 'current' => false])

<a
    href="{{ $href }}"
    {{ $attributes->class(
        'border-b-2 px-3 py-2 text-sm font-medium transition '
        . ($current
            ? 'border-(--pulse-accent) text-(--pulse-accent-text)'
            : 'border-transparent text-(--pulse-neutral-500) hover:border-(--pulse-neutral-300) hover:text-(--pulse-neutral-700) dark:text-(--pulse-neutral-400) dark:hover:border-(--pulse-neutral-700) dark:hover:text-(--pulse-neutral-200)')
    ) }}
>
    {{ $slot }}
</a>
