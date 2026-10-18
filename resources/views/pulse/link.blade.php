@props(['icon' => null])

<a {{ $attributes->class('inline-flex items-center gap-1.5 text-sm font-medium text-(--pulse-accent-text) underline decoration-(--pulse-accent-text)/40 underline-offset-2 hover:decoration-(--pulse-accent-text)') }}>
    @if ($icon)
        <x-pulse::icon name="{{ $icon }}" class="h-4 w-4" />
    @endif
    {{ $slot }}
</a>
