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
/**
 * Collapsible children behind <x-pulse::sidebar.collapsible>. Vanilla JS,
 * no framework dependency. Wires every [data-pulse-sidebar-group] root
 * found on the page at load. State is in-memory only — nothing is
 * persisted, so every page load starts collapsed.
 */
function initSidebarGroup(root) {
    var toggles = root.querySelectorAll('[data-pulse-sidebar-group-toggle]');
    var panel = root.querySelector('[data-pulse-sidebar-group-panel]');
    var chevron = root.querySelector('[data-pulse-sidebar-group-chevron]');

    if (!toggles.length || !panel) {
        return;
    }

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            var isOpen = !panel.classList.contains('hidden');

            panel.classList.toggle('hidden', isOpen);

            toggles.forEach(function (t) {
                t.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
            });

            if (chevron) {
                chevron.classList.toggle('rotate-180', !isOpen);
            }
        });
    });
}

document.querySelectorAll('[data-pulse-sidebar-group]').forEach(initSidebarGroup);
