@props(['disabled' => false])

<span class="relative block w-full">
    <select
        data-pulse-select
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->class('block w-full appearance-none border-0 border-b-2 border-(--pulse-neutral-300) bg-transparent px-1 py-2 pr-7 text-(--pulse-neutral-900) transition focus:border-(--pulse-accent) focus:outline-none focus:ring-0 sm:text-sm disabled:cursor-not-allowed disabled:text-(--pulse-neutral-400) dark:text-(--pulse-neutral-50) dark:border-(--pulse-neutral-700)') }}
    >
        {{ $slot }}
    </select>
    <x-pulse::icon
        name="chevron-down"
        data-pulse-select-fallback-icon
        class="pointer-events-none absolute right-1 top-1/2 h-4 w-4 -translate-y-1/2 text-(--pulse-neutral-400)"
    />
</span>
