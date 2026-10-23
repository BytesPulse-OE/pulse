@props(['confirmLabel' => 'Confirm', 'cancelLabel' => 'Cancel'])

{{--
    Reusable confirm dialog, replacing window.confirm() with Pulse-styled
    UI. Include once per page:
        <x-pulse::confirm-dialog />

    Opened programmatically from JS via window.ConfirmDialog.ask(message, {
        title: '...', confirmLabel: '...', cancelLabel: '...',
    }) -- returns a Promise<boolean>. See resources/js/confirm-dialog.js
    (published via `php artisan vendor:publish --tag=pulse-js`). Not opened
    via data-* trigger attributes like the media picker, since every caller
    needs the resolved answer before continuing, not just a fire-and-forget
    open.
--}}
<div
    id="confirm-dialog"
    {{ $attributes->class('fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4') }}
    data-confirm-dialog
    role="alertdialog"
    aria-modal="true"
    aria-labelledby="confirm-dialog-title"
    aria-describedby="confirm-dialog-message"
>
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl dark:bg-(--pulse-neutral-900)">
        <h2 id="confirm-dialog-title" class="text-base font-semibold text-(--pulse-neutral-900) dark:text-(--pulse-neutral-50)" data-confirm-dialog-title></h2>
        <p id="confirm-dialog-message" class="mt-2 text-sm text-(--pulse-neutral-600) dark:text-(--pulse-neutral-400)" data-confirm-dialog-message></p>

        <div class="mt-5 flex justify-end gap-3">
            <x-pulse::button type="button" variant="secondary" class="!px-4 !py-1.5 !text-xs" data-confirm-dialog-cancel>
                {{ $cancelLabel }}
            </x-pulse::button>
            <x-pulse::button type="button" class="!px-4 !py-1.5 !text-xs" data-confirm-dialog-confirm>
                {{ $confirmLabel }}
            </x-pulse::button>
        </div>
    </div>
</div>
