@props(['heading' => null])

<div {{ $attributes->class('space-y-1') }}>
    @if ($heading)
        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-(--pulse-neutral-400) dark:text-(--pulse-neutral-500)">
            {{ $heading }}
        </p>
    @endif

    {{ $slot }}
</div>
