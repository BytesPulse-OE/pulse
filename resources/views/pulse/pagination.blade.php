@props([
    'paginator',
    'previousLabel' => 'Previous',
    'nextLabel' => 'Next',
    'summary' => null,
])

@php
    $elements = method_exists($paginator, 'links') ? $paginator->elements() : [];
@endphp

@if ($paginator->hasPages())
    <nav {{ $attributes->class('flex items-center justify-between gap-4') }} role="navigation" aria-label="Pagination">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium text-(--pulse-neutral-400) dark:text-(--pulse-neutral-600)">
                    <x-pulse::icon name="chevron-left" class="h-4 w-4" />
                    {{ $previousLabel }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-200) dark:hover:bg-(--pulse-neutral-800)">
                    <x-pulse::icon name="chevron-left" class="h-4 w-4" />
                    {{ $previousLabel }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-200) dark:hover:bg-(--pulse-neutral-800)">
                    {{ $nextLabel }}
                    <x-pulse::icon name="chevron-right" class="h-4 w-4" />
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium text-(--pulse-neutral-400) dark:text-(--pulse-neutral-600)">
                    {{ $nextLabel }}
                    <x-pulse::icon name="chevron-right" class="h-4 w-4" />
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <p class="text-sm text-(--pulse-neutral-500) dark:text-(--pulse-neutral-400)">
                {{ $summary ?? 'Showing ' . $paginator->firstItem() . ' to ' . $paginator->lastItem() . ' of ' . $paginator->total() . ' results' }}
            </p>

            <div class="flex items-center gap-1">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-(--pulse-neutral-300) dark:text-(--pulse-neutral-700)">
                        <x-pulse::icon name="chevron-left" class="h-4 w-4" />
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-(--pulse-neutral-600) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-300) dark:hover:bg-(--pulse-neutral-800)" aria-label="{{ $previousLabel }}">
                        <x-pulse::icon name="chevron-left" class="h-4 w-4" />
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex h-9 w-9 items-center justify-center text-sm text-(--pulse-neutral-400) dark:text-(--pulse-neutral-600)">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-(--pulse-accent) text-sm font-semibold text-(--pulse-accent-contrast)" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-medium text-(--pulse-neutral-700) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-200) dark:hover:bg-(--pulse-neutral-800)">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-(--pulse-neutral-600) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-300) dark:hover:bg-(--pulse-neutral-800)" aria-label="{{ $nextLabel }}">
                        <x-pulse::icon name="chevron-right" class="h-4 w-4" />
                    </a>
                @else
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-(--pulse-neutral-300) dark:text-(--pulse-neutral-700)">
                        <x-pulse::icon name="chevron-right" class="h-4 w-4" />
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
