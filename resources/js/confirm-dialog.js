/**
 * Reusable confirm dialog, replacing window.confirm() for flows that need
 * Pulse-styled UI instead of a native browser alert. Promise-based so a
 * caller can `await` the answer:
 *
 *   var confirmed = await window.ConfirmDialog.ask('Replace the content?', {
 *       title: 'Replace content',
 *   });
 *
 * Markup lives once per page as <x-pulse::confirm-dialog /> (id="confirm-dialog");
 * this module finds and enhances it lazily on first use the same way
 * select.js enhances [data-pulse-select].
 */
(function () {
    function enhance(dialog) {
        if (dialog.dataset.confirmDialogReady) {
            return dialog;
        }
        dialog.dataset.confirmDialogReady = 'true';

        var titleEl = dialog.querySelector('[data-confirm-dialog-title]');
        var messageEl = dialog.querySelector('[data-confirm-dialog-message]');
        var confirmBtn = dialog.querySelector('[data-confirm-dialog-confirm]');
        var cancelBtn = dialog.querySelector('[data-confirm-dialog-cancel]');
        var defaultConfirmLabel = confirmBtn.textContent.trim();
        var defaultCancelLabel = cancelBtn.textContent.trim();
        var resolveActive = null;

        function settle(result) {
            dialog.classList.add('hidden');
            dialog.classList.remove('flex');
            if (resolveActive) {
                var resolve = resolveActive;
                resolveActive = null;
                resolve(result);
            }
        }

        confirmBtn.addEventListener('click', function () {
            settle(true);
        });
        cancelBtn.addEventListener('click', function () {
            settle(false);
        });
        dialog.addEventListener('click', function (event) {
            if (event.target === dialog) {
                settle(false);
            }
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !dialog.classList.contains('hidden')) {
                settle(false);
            }
        });

        dialog.__ask = function (message, options) {
            options = options || {};
            titleEl.textContent = options.title || '';
            titleEl.classList.toggle('hidden', !options.title);
            messageEl.textContent = message;
            confirmBtn.textContent = options.confirmLabel || defaultConfirmLabel;
            cancelBtn.textContent = options.cancelLabel || defaultCancelLabel;

            dialog.classList.remove('hidden');
            dialog.classList.add('flex');
            confirmBtn.focus();

            return new Promise(function (resolve) {
                resolveActive = resolve;
            });
        };

        return dialog;
    }

    function ask(message, options) {
        var dialog = document.getElementById('confirm-dialog');

        if (!dialog) {
            return Promise.resolve(window.confirm(message));
        }

        enhance(dialog);

        return dialog.__ask(message, options);
    }

    window.ConfirmDialog = { ask: ask };
})();
