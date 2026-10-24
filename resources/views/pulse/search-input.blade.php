@props(['name' => 'q', 'value' => '', 'placeholder' => 'Search…'])

<span class="relative block">
    <x-pulse::icon
        name="search"
        class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-(--pulse-neutral-400)"
    />
    <input
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class('block w-full rounded-full border border-(--pulse-neutral-300) bg-transparent py-2 pl-10 pr-4 text-sm text-(--pulse-neutral-900) placeholder:text-(--pulse-neutral-400) transition focus:border-(--pulse-accent) focus:outline-none focus:ring-0 dark:text-(--pulse-neutral-50) dark:border-(--pulse-neutral-700) dark:placeholder:text-(--pulse-neutral-500)') }}
    >
</span>
