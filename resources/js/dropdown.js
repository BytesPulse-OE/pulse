/**
 * Click-to-open/close behavior for <x-pulse::dropdown>. Vanilla JS, no
 * framework dependency — same style as sidebar.js/select.js. Wires every
 * [data-pulse-dropdown] root found on the page at load.
 */
function initDropdown(root) {
    var trigger = root.querySelector('[data-pulse-dropdown-trigger]');
    var panel = root.querySelector('[data-pulse-dropdown-panel]');

    if (!trigger || !panel) {
        return;
    }

    function isOpen() {
        return !panel.classList.contains('hidden');
    }

    function open() {
        root.style.setProperty('--pulse-dropdown-width', trigger.offsetWidth + 'px');
        panel.classList.remove('hidden');
    }

    function close() {
        panel.classList.add('hidden');
    }

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        isOpen() ? close() : open();
    });

    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) {
            close();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            close();
        }
    });
}

document.querySelectorAll('[data-pulse-dropdown]').forEach(initDropdown);
