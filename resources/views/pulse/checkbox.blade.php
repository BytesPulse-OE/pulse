@props(['disabled' => false])

<span class="relative inline-flex h-5 w-5 shrink-0">
    <input
        type="checkbox"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->class('peer h-5 w-5 shrink-0 cursor-pointer appearance-none rounded-full border-2 border-(--pulse-neutral-300) bg-white transition checked:border-(--pulse-accent) checked:bg-(--pulse-accent) focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-(--pulse-accent) disabled:cursor-not-allowed disabled:opacity-50 dark:border-(--pulse-neutral-600) dark:bg-(--pulse-neutral-800)') }}
    >
    <svg
        class="pointer-events-none absolute inset-0 h-5 w-5 p-[7px] text-(--pulse-accent-contrast) opacity-0 transition peer-checked:opacity-100"
        viewBox="0 0 12 12"
        fill="none"
        stroke="currentColor"
        stroke-width="1.75"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <path d="M2.5 6.5 5 9l4.5-6" />
    </svg>
</span>
