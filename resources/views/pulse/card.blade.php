@props(['hoverable' => false])

<div {{ $attributes->class([
    'w-full rounded-2xl border border-(--pulse-neutral-200) bg-white p-8 text-(--pulse-neutral-700) dark:border-(--pulse-neutral-800) dark:bg-(--pulse-neutral-900) dark:text-(--pulse-neutral-300)',
    'transition-colors hover:border-(--pulse-neutral-300) dark:hover:border-(--pulse-neutral-700)' => $hoverable,
]) }}>
    {{ $slot }}
</div>
