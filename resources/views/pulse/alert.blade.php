@props(['variant' => 'success'])

@php
$colorClasses = $variant === 'error'
    ? 'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300'
    : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300';

$iconName = $variant === 'error' ? 'warning' : 'check';
$iconClasses = $variant === 'error'
    ? 'text-red-500 dark:text-red-400'
    : 'text-emerald-500 dark:text-emerald-400';
@endphp

<div {{ $attributes->class("flex items-start gap-3 rounded-2xl px-4 py-3 text-sm font-medium $colorClasses") }}>
    <x-pulse::icon name="{{ $iconName }}" class="mt-0.5 h-5 w-5 shrink-0 {{ $iconClasses }}" />
    <div class="flex-1">{{ $slot }}</div>
</div>
