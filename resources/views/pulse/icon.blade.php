@props(['name' => null, 'svg' => null, 'view' => null])

@if ($svg)
    <span {{ $attributes->class(['h-5 w-5' => ! $attributes->has('class')]) }}>{!! $svg !!}</span>
@elseif ($view)
    <span {{ $attributes->class(['h-5 w-5' => ! $attributes->has('class')]) }}>@include($view)</span>
@else
    <x-dynamic-component
        :component="'pulse::icon.' . $name"
        {{ $attributes->class(['h-5 w-5' => ! $attributes->has('class')]) }}
    />
@endif
