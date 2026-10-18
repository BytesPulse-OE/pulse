@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->class('block w-full border-0 border-b border-(--pulse-neutral-300) bg-transparent px-1 py-2 text-(--pulse-neutral-900) placeholder:text-(--pulse-neutral-400) focus:border-(--pulse-accent) focus:outline-none focus:ring-0 sm:text-sm disabled:border-(--pulse-neutral-200) disabled:text-(--pulse-neutral-400) dark:text-(--pulse-neutral-50) dark:border-(--pulse-neutral-700) dark:placeholder:text-(--pulse-neutral-500) [&:-webkit-autofill]:[-webkit-text-fill-color:var(--pulse-neutral-900)] [&:-webkit-autofill]:[box-shadow:inset_0_0_0_1000px_var(--pulse-neutral-50)] [&:-webkit-autofill]:[transition:background-color_600000s_0s,color_600000s_0s] dark:[&:-webkit-autofill]:[-webkit-text-fill-color:var(--pulse-neutral-50)] dark:[&:-webkit-autofill]:[box-shadow:inset_0_0_0_1000px_var(--pulse-neutral-900)]') }}
>
