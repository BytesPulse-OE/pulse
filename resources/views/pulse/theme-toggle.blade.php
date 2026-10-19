@props([
    'name' => 'appearance',
    'value' => 'system',
    'options' => [
        'system' => ['label' => 'System', 'icon' => 'device-desktop'],
        'light' => ['label' => 'Light', 'icon' => 'sun'],
        'dark' => ['label' => 'Dark', 'icon' => 'moon'],
    ],
])

{{--
    Pure CSS, no JS required — a real radio input per option, visually
    hidden (peer), with the pill look driven entirely by peer-checked. Works
    in a plain HTML form with zero JS, same progressive-enhancement
    philosophy as the rest of this package.
--}}
<div {{ $attributes->class('inline-flex items-center gap-0.5 rounded-full bg-(--pulse-neutral-100) p-1 dark:bg-(--pulse-neutral-800)') }}>
    @foreach ($options as $optionValue => $option)
        <label class="relative cursor-pointer">
            <input
                type="radio"
                name="{{ $name }}"
                value="{{ $optionValue }}"
                class="peer sr-only"
                {{ $optionValue === $value ? 'checked' : '' }}
            >
            <span class="flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-(--pulse-neutral-600) transition peer-checked:bg-(--pulse-accent) peer-checked:text-(--pulse-accent-contrast) dark:text-(--pulse-neutral-300)">
                <x-pulse::icon name="{{ $option['icon'] }}" class="h-4 w-4" />
                {{ $option['label'] }}
            </span>
        </label>
    @endforeach
</div>
