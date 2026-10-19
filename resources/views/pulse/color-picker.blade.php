@props(['name' => 'accent', 'value' => null, 'options' => []])

@php
    $value = $value ?? array_key_first($options);
    $selected = $options[$value] ?? null;
@endphp

{{--
    Collapsed "current swatch + label" trigger that expands into the full
    grid on click (resources/js/color-picker.js). Without that JS, the
    trigger stays hidden and the grid is simply always visible — a plain,
    fully accessible, fully functional set of radio-backed swatches. Real
    radio inputs throughout, so this works inside an ordinary HTML form with
    zero JS, same as every other component in this package.
--}}
<div data-pulse-color-picker {{ $attributes->class('inline-block') }}>
    <button
        type="button"
        data-pulse-color-picker-trigger
        class="hidden items-center gap-2 rounded-full bg-(--pulse-neutral-100) py-1.5 pl-1.5 pr-3 text-xs font-semibold text-(--pulse-neutral-700) dark:bg-(--pulse-neutral-800) dark:text-(--pulse-neutral-200)"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <span data-pulse-color-picker-dot class="h-6 w-6 rounded-full {{ $selected['class'] ?? '' }}"></span>
        <span data-pulse-color-picker-label>{{ $selected['label'] ?? '' }}</span>
        <x-pulse::icon name="chevron-down" class="h-3.5 w-3.5 text-(--pulse-neutral-400)" />
    </button>

    <div data-pulse-color-picker-panel class="mt-3 flex flex-wrap gap-3">
        @foreach ($options as $optionValue => $option)
            <label class="relative cursor-pointer">
                <input
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $optionValue }}"
                    class="peer sr-only"
                    data-pulse-color-picker-option
                    data-label="{{ $option['label'] }}"
                    data-swatch-class="{{ $option['class'] }}"
                    {{ $optionValue === $value ? 'checked' : '' }}
                >
                <span class="block h-8 w-8 rounded-full {{ $option['class'] }} ring-2 ring-offset-2 ring-offset-white ring-transparent transition peer-checked:ring-(--pulse-accent) peer-focus-visible:ring-(--pulse-accent) dark:ring-offset-(--pulse-neutral-900)"></span>
                <x-pulse::icon name="check" class="pointer-events-none absolute inset-0 m-auto hidden h-4 w-4 {{ $option['check_class'] ?? 'text-white' }} peer-checked:block" />
                <span class="sr-only">{{ $option['label'] }}</span>
            </label>
        @endforeach
    </div>
</div>
