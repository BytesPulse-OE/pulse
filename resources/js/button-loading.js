/**
 * Loading state for <x-pulse::button>. Two ways to trigger it:
 *
 * 1. Automatic: any <button type="submit"> inside a <form> gets disabled
 *    with a spinner shown the moment that form is submitted. Opt a form out
 *    with <form data-no-loading>, or a single button out with
 *    <x-pulse::button data-no-loading>.
 *
 * 2. Manual: for buttons not driven by a plain form submit (fetch calls,
 *    Livewire actions, anything async), call the exported API directly:
 *
 *   PulseButton.setLoading(buttonEl, true);   // enable
 *   PulseButton.setLoading(buttonEl, false);  // disable
 *
 * Both paths toggle the same markup the Blade component renders when given
 * :loading="true" -- the button's own .pulse-button-spinner/-icon/-label,
 * so server-rendered and JS-triggered loading states look identical.
 */
(function () {
    function setLoading(button, loading) {
        if (!(button instanceof HTMLElement)) {
            return;
        }

        var spinner = button.querySelector('.pulse-button-spinner');
        var icon = button.querySelector('.pulse-button-icon');

        if (loading) {
            if (button.dataset.pulseLoading) {
                return;
            }
            button.dataset.pulseLoading = 'true';
            button.disabled = true;
            if (spinner) spinner.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
        } else {
            delete button.dataset.pulseLoading;
            button.disabled = false;
            if (spinner) spinner.classList.add('hidden');
            if (icon) icon.classList.remove('hidden');
        }
    }

    document.addEventListener('submit', function (event) {
        var form = event.target;

        if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-no-loading') || event.defaultPrevented) {
            return;
        }

        form.querySelectorAll('button[type="submit"]').forEach(function (button) {
            if (!button.hasAttribute('data-no-loading')) {
                setLoading(button, true);
            }
        });
    });

    window.PulseButton = { setLoading: setLoading };
})();
