{{-- Mobile open/close is handled by the consuming app's own JS via the
     data-pulse-sidebar-* attributes below (vanilla JS, no framework
     dependency required from this package). --}}
<div data-pulse-sidebar>
    <div class="flex items-center justify-between border-b border-(--pulse-neutral-200) bg-white px-4 py-3 dark:border-(--pulse-neutral-800) dark:bg-(--pulse-neutral-900) lg:hidden">
        <div class="font-semibold text-(--pulse-neutral-900) dark:text-(--pulse-neutral-50)">
            {{ $brand ?? '' }}
        </div>
        <button
            type="button"
            data-pulse-sidebar-toggle
            class="rounded-lg p-2 text-(--pulse-neutral-500) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-400) dark:hover:bg-(--pulse-neutral-800)"
            aria-label="Open navigation"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <div data-pulse-sidebar-overlay class="fixed inset-0 z-30 hidden bg-black/30 lg:hidden"></div>

    <aside
        data-pulse-sidebar-panel
        {{ $attributes->class('fixed left-0 top-0 z-40 flex h-screen w-64 -translate-x-full shrink-0 flex-col border-r border-(--pulse-neutral-200) bg-white transition-transform duration-200 dark:border-(--pulse-neutral-800) dark:bg-(--pulse-neutral-900) lg:sticky lg:translate-x-0') }}
    >
        <div class="flex h-16 shrink-0 items-center justify-between border-b border-(--pulse-neutral-200) px-4 dark:border-(--pulse-neutral-800) lg:hidden">
            <span class="font-semibold text-(--pulse-neutral-900) dark:text-(--pulse-neutral-50)">{{ $brand ?? '' }}</span>
            <button
                type="button"
                data-pulse-sidebar-close
                class="rounded-lg p-2 text-(--pulse-neutral-500) hover:bg-(--pulse-neutral-100) dark:text-(--pulse-neutral-400) dark:hover:bg-(--pulse-neutral-800)"
                aria-label="Close navigation"
            >
                <x-pulse::icon name="close" class="h-5 w-5" />
            </button>
        </div>

        @isset($brand)
            <div class="hidden h-16 shrink-0 items-center border-b border-(--pulse-neutral-200) px-4 font-semibold text-(--pulse-neutral-900) dark:border-(--pulse-neutral-800) dark:text-(--pulse-neutral-50) lg:flex">
                {{ $brand }}
            </div>
        @endisset

        <nav class="flex flex-1 flex-col space-y-4 overflow-y-auto px-3 py-4">
            {{ $slot }}
        </nav>

        @isset($footer)
            <div class="shrink-0 border-t border-(--pulse-neutral-200) p-3 dark:border-(--pulse-neutral-800)">
                {{ $footer }}
            </div>
        @endisset
    </aside>
</div>
