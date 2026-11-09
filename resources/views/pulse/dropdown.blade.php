@props(['align' => 'start', 'placement' => 'bottom'])

@php
$alignClasses = $align === 'end' ? 'right-0' : 'left-0';
$placementClasses = $placement === 'top'
    ? 'bottom-full mb-2'
    : 'top-full mt-2';
@endphp

<div {{ $attributes->class('relative') }} data-pulse-dropdown>
    <div data-pulse-dropdown-trigger>
        {{ $trigger }}
    </div>

    <div
        data-pulse-dropdown-panel
        class="hidden absolute z-50 {{ $alignClasses }} {{ $placementClasses }} min-w-[var(--pulse-dropdown-width)] w-max rounded-lg border border-(--pulse-neutral-200) bg-white py-1 shadow-lg dark:border-(--pulse-neutral-700) dark:bg-(--pulse-neutral-900)"
    >
        {{ $slot }}
    </div>
</div>
