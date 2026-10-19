/**
 * Progressive-enhancement custom dropdown for <x-pulse::select>.
 *
 * A native <option> list can't be restyled past very limited CSS (browsers
 * draw it themselves, OS-level, no further control over colors/spacing in
 * any browser) — getting a styled options panel means building one. The
 * real <select> stays in the DOM, visually hidden once this runs, so the
 * element forms/labels/validation already target keeps working unchanged;
 * this only replaces how the open options list looks and is driven.
 *
 * Vanilla JS, no framework dependency — consistent with sidebar.js (this
 * package's other interactive component) and with a consuming app's own
 * theming script, if it has one.
 */
(function () {
    var instanceId = 0;

    function svg(pathD, extraClass) {
        var ns = 'http://www.w3.org/2000/svg';
        var el = document.createElementNS(ns, 'svg');
        el.setAttribute('viewBox', '0 0 24 24');
        el.setAttribute('fill', 'none');
        el.setAttribute('stroke', 'currentColor');
        el.setAttribute('stroke-width', '2');
        el.setAttribute('stroke-linecap', 'round');
        el.setAttribute('stroke-linejoin', 'round');
        el.setAttribute('aria-hidden', 'true');
        el.setAttribute('class', extraClass);

        var path = document.createElementNS(ns, 'path');
        path.setAttribute('d', pathD);
        el.appendChild(path);

        return el;
    }

    function enhance(select) {
        if (select.dataset.pulseSelectReady) {
            return;
        }
        select.dataset.pulseSelectReady = 'true';

        instanceId += 1;
        var uid = 'pulse-select-' + instanceId;

        var wrapper = select.parentNode;
        var fallbackIcon = wrapper.querySelector('[data-pulse-select-fallback-icon]');
        if (fallbackIcon) {
            fallbackIcon.remove();
        }

        select.classList.add('sr-only');
        select.setAttribute('tabindex', '-1');
        select.setAttribute('aria-hidden', 'true');

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.id = uid + '-trigger';
        trigger.disabled = select.disabled;
        trigger.className = 'flex w-full items-center justify-between gap-2 border-0 border-b border-(--pulse-neutral-300) bg-transparent px-1 py-2 text-left text-sm text-(--pulse-neutral-900) transition focus:border-(--pulse-accent) focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:text-(--pulse-neutral-50) dark:border-(--pulse-neutral-700)';
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');

        var label = document.createElement('span');
        label.className = 'truncate';
        trigger.appendChild(label);

        var chevron = svg('M6 9l6 6 6-6', 'h-4 w-4 shrink-0 text-(--pulse-neutral-400) transition-transform duration-150');
        trigger.appendChild(chevron);

        var listbox = document.createElement('ul');
        listbox.id = uid + '-listbox';
        listbox.setAttribute('role', 'listbox');
        listbox.tabIndex = -1;
        listbox.className = 'absolute inset-x-0 top-full z-20 mt-1 hidden max-h-60 overflow-auto rounded-lg bg-white py-1 text-sm shadow-lg ring-1 ring-(--pulse-neutral-200) focus:outline-none dark:bg-(--pulse-neutral-900) dark:ring-(--pulse-neutral-700)';
        trigger.setAttribute('aria-controls', listbox.id);

        var options = Array.prototype.slice.call(select.options);
        var items = [];
        var activeIndex = 0;

        options.forEach(function (option, index) {
            if (option.selected) {
                activeIndex = index;
            }

            var item = document.createElement('li');
            item.setAttribute('role', 'option');
            item.id = uid + '-option-' + index;
            item.setAttribute('aria-selected', option.selected ? 'true' : 'false');
            item.className = 'flex cursor-pointer items-center justify-between gap-2 rounded-md px-3 py-2 text-(--pulse-neutral-900) transition dark:text-(--pulse-neutral-50)';

            var text = document.createElement('span');
            text.className = 'truncate';
            text.textContent = option.textContent;
            item.appendChild(text);

            var check = svg('M5 13l4 4L19 7', 'h-4 w-4 shrink-0 text-(--pulse-accent) ' + (option.selected ? '' : 'invisible'));
            item.appendChild(check);

            listbox.appendChild(item);
            items.push({ el: item, check: check });

            item.addEventListener('click', function () {
                selectIndex(index);
                close();
            });

            item.addEventListener('mouseenter', function () {
                highlight(index);
            });
        });

        wrapper.appendChild(trigger);
        wrapper.appendChild(listbox);

        function syncLabel() {
            var selected = options[select.selectedIndex];
            label.textContent = selected ? selected.textContent : '';
        }

        function highlight(index) {
            items.forEach(function (item, i) {
                item.el.classList.toggle('bg-(--pulse-accent)/10', i === index);
                item.el.classList.toggle('dark:bg-(--pulse-accent)/15', i === index);
                item.el.classList.toggle('text-(--pulse-accent-text)', i === index);
            });
            activeIndex = index;
            trigger.setAttribute('aria-activedescendant', items[index].el.id);
        }

        function isOpen() {
            return !listbox.classList.contains('hidden');
        }

        function open() {
            if (trigger.disabled) {
                return;
            }
            listbox.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
            chevron.classList.add('rotate-180');
            highlight(select.selectedIndex === -1 ? 0 : select.selectedIndex);
        }

        function close() {
            listbox.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
            trigger.removeAttribute('aria-activedescendant');
            chevron.classList.remove('rotate-180');
        }

        function selectIndex(index) {
            select.selectedIndex = index;
            items.forEach(function (item, i) {
                item.el.setAttribute('aria-selected', i === index ? 'true' : 'false');
                item.check.classList.toggle('invisible', i !== index);
            });
            syncLabel();
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }

        trigger.addEventListener('click', function () {
            if (isOpen()) {
                close();
                trigger.focus();
            } else {
                open();
            }
        });

        // Focus never actually moves to the listbox — the trigger stays
        // focused throughout and drives navigation, per the ARIA "listbox
        // popup" pattern, so there's only this one keydown handler.
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                isOpen() ? highlight(Math.min(activeIndex + 1, items.length - 1)) : open();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                isOpen() ? highlight(Math.max(activeIndex - 1, 0)) : open();
            } else if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (isOpen()) {
                    selectIndex(activeIndex);
                    close();
                } else {
                    open();
                }
            } else if (e.key === 'Escape') {
                close();
            } else if (e.key === 'Tab') {
                close();
            }
        });

        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) {
                close();
            }
        });

        syncLabel();
    }

    document.querySelectorAll('[data-pulse-select]').forEach(enhance);
})();
