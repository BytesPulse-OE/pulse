@props(['icon' => 'globe', 'url', 'label' => null])

<a
    href="{{ $url }}"
    target="_blank"
    rel="noopener"
    @if ($label) title="{{ $label }}" @endif
    {{ $attributes->class('inline-flex') }}
>
    <x-pulse::icon name="{{ 'social-'.$icon }}" class="h-4 w-4" />
</a>
