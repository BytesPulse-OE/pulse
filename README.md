<h1 align="center"><img src="art/logo.svg" alt="" width="28" valign="middle"> Pulse</h1>

Lightweight Blade components for Laravel and Livewire applications.

## Install

```bash
composer require bytespulse-oe/pulse
```

Nothing else required — the service provider is auto-discovered and
registers the `pulse` component namespace immediately.

```blade
<x-pulse::button variant="primary">Save</x-pulse::button>
<x-pulse::input type="email" wire:model="email" />
<x-pulse::icon name="check" />
```

## Theming

Components read their colors from a small set of CSS custom properties —
`--pulse-neutral-50` through `--pulse-neutral-950`, and `--pulse-accent` /
`--pulse-accent-text` / `--pulse-accent-contrast`. Define them once in your
own stylesheet (or override per-app) and every component picks them up.

## Interactive components

`<x-pulse::select>` and `<x-pulse::sidebar>` need a small amount of
JavaScript (the custom dropdown, and the mobile open/close behavior). The
package ships plain, dependency-free source files for these — no bundler of
its own — so you pull them into your own app's JS build:

```bash
php artisan vendor:publish --tag=pulse-js
```

This copies `select.js` and `sidebar.js` into
`resources/js/vendor/pulse/`. Import whichever components you use from your
own `resources/js/app.js`:

```js
import './vendor/pulse/select.js';
import './vendor/pulse/sidebar.js';
```

Every other component (button, card, input, and the rest) is markup/CSS
only — nothing to import for those.

## Icons

The bundled icon set is an original set designed by the BytesPulse O.E.
team for this package.

## Overriding a component

Place a Blade view at the same relative path under your own application's
`resources/views/pulse/` directory to override a bundled component — it's
checked before the package's own version.

## License

MIT.
