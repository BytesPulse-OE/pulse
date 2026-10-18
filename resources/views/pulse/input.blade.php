@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->class('block w-full border-0 border-b border-(--pulse-neutral-300) bg-transparent px-1 py-2 text-(--pulse-neutral-900) placeholder:text-(--pulse-neutral-400) focus:border-(--pulse-accent) focus:outline-none focus:ring-0 sm:text-sm disabled:border-(--pulse-neutral-200) disabled:text-(--pulse-neutral-400) dark:text-(--pulse-neutral-50) dark:border-(--pulse-neutral-700) dark:placeholder:text-(--pulse-neutral-500) autofill:shadow-[inset_0_0_0_1000px_var(--pulse-neutral-50)] autofill:[-webkit-text-fill-color:var(--pulse-neutral-900)] dark:autofill:shadow-[inset_0_0_0_1000px_var(--pulse-neutral-900)] dark:autofill:[-webkit-text-fill-color:var(--pulse-neutral-50)]') }}
>
