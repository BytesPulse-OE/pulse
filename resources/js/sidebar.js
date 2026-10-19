/**
 * Mobile open/close behavior for <x-pulse::sidebar>. Vanilla JS, no
 * framework dependency. Wires every [data-pulse-sidebar] root found on the
 * page at load.
 */
function initSidebar(root) {
    var toggle = root.querySelector('[data-pulse-sidebar-toggle]');
    var overlay = root.querySelector('[data-pulse-sidebar-overlay]');
    var panel = root.querySelector('[data-pulse-sidebar-panel]');
    var closeButton = panel ? panel.querySelector('[data-pulse-sidebar-close]') : null;

    if (!panel) {
        return;
    }

    function open() {
        panel.classList.remove('-translate-x-full');

        if (overlay) {
            overlay.classList.remove('hidden');
        }
    }

    function close() {
        panel.classList.add('-translate-x-full');

        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    if (toggle) {
        toggle.addEventListener('click', open);
    }

    if (overlay) {
        overlay.addEventListener('click', close);
    }

    if (closeButton) {
        closeButton.addEventListener('click', close);
    }
}

document.querySelectorAll('[data-pulse-sidebar]').forEach(initSidebar);
