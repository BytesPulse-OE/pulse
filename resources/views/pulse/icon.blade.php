@props(['name'])

<x-dynamic-component
    :component="'pulse::icon.' . $name"
    {{ $attributes->class(['h-5 w-5' => ! $attributes->has('class')]) }}
/>
