/**
 * Progressive-enhancement collapse/expand behavior for
 * <x-pulse::color-picker>.
 *
 * The component's fallback markup — a plain grid of radio-backed swatches —
 * is fully functional and accessible with zero JS. This only adds the
 * "current swatch + label" trigger that collapses that grid and expands it
 * on click, keeps the trigger in sync with whichever swatch is actually
 * selected (including via keyboard — these stay real radio inputs), and
 * closes on an outside click or Escape.
 */
(function () {
    function enhance(root) {
        if (root.dataset.pulseColorPickerReady) {
            return;
        }
        root.dataset.pulseColorPickerReady = 'true';

        var trigger = root.querySelector('[data-pulse-color-picker-trigger]');
        var panel = root.querySelector('[data-pulse-color-picker-panel]');
        var dot = root.querySelector('[data-pulse-color-picker-dot]');
        var label = root.querySelector('[data-pulse-color-picker-label]');
        var options = root.querySelectorAll('[data-pulse-color-picker-option]');

        if (!trigger || !panel) {
            return;
        }

        trigger.classList.remove('hidden');
        trigger.classList.add('inline-flex');

        function sync() {
            var checked = root.querySelector('[data-pulse-color-picker-option]:checked');

            if (!checked) {
                return;
            }

            if (dot) {
                dot.className = 'h-6 w-6 rounded-full ' + (checked.dataset.swatchClass || '');
            }

            if (label) {
                label.textContent = checked.dataset.label || '';
            }
        }

        function open() {
            panel.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
        }

        function close() {
            panel.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', function () {
            if (panel.classList.contains('hidden')) {
                open();
            } else {
                close();
            }
        });

        options.forEach(function (option) {
            option.addEventListener('change', function () {
                sync();
                close();
                trigger.focus();
            });
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) {
                close();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                close();
            }
        });

        sync();
        close();
    }

    document.querySelectorAll('[data-pulse-color-picker]').forEach(enhance);
})();
