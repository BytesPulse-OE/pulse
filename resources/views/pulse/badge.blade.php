@props(['variant' => 'secondary'])

@php
$colorClasses = match ($variant) {
    'primary' => 'bg-(--pulse-accent) text-(--pulse-accent-contrast)',
    'warning' => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
    'danger' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
    default => 'bg-(--pulse-neutral-100) text-(--pulse-neutral-700) dark:bg-(--pulse-neutral-800) dark:text-(--pulse-neutral-300)',
};
@endphp

<span {{ $attributes->class("inline-flex w-fit shrink-0 items-center rounded-full px-2.5 py-0.5 text-xs font-semibold $colorClasses") }}>
    {{ $slot }}
</span>
