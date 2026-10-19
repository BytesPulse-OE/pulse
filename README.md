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

A small JS engine that APPLIES those variables from three preferences
(appearance: light/dark/system, a neutral palette, an accent color) ships
alongside the components — see "JavaScript" below. It's optional: define
the CSS variables yourself, by any means, and the components don't care.

## JavaScript

Three pieces of plain, dependency-free JS — no bundler of its own, so you
pull whichever you need into your own app's JS build:

```bash
php artisan vendor:publish --tag=pulse-js
```

This copies `select.js`, `sidebar.js`, and `theme.js` into
`resources/js/vendor/pulse/`.

- **`select.js`** — the custom dropdown behind `<x-pulse::select>`.
- **`sidebar.js`** — mobile open/close behavior behind `<x-pulse::sidebar>`.
- **`theme.js`** — the theming engine (see "Theming" above): a `PulseTheme`
  class that applies appearance/neutral/accent preferences to the
  `--pulse-*` CSS variables. It owns applying a preference, not picking one
  — wire it to your own settings UI:

  ```js
  import PulseTheme from './vendor/pulse/theme.js';

  const theme = new PulseTheme();
  theme.applyAll();                 // apply saved/default preferences on load
  theme.setAccent('teal');          // -> persists + re-applies
  theme.neutrals;                   // -> ['slate', 'gray', 'zinc', 'neutral', 'stone']
  theme.accents;                    // -> ['red', 'orange', ..., 'rose']
  ```

  Persistence defaults to plain `localStorage` under `pulse-theme.*` keys,
  and is fully overridable via the constructor (`storagePrefix`, `read`,
  `write`, `defaults`) — e.g. to skip persistence inside a preview iframe,
  scope keys per-tenant, or persist server-side instead:

  ```js
  const theme = new PulseTheme({
      storagePrefix: 'my-app-theme',
      defaults: { accent: 'teal' },
  });
  ```

Import whichever of the three you use from your own `resources/js/app.js`:

```js
import './vendor/pulse/select.js';
import './vendor/pulse/sidebar.js';
import './vendor/pulse/theme.js';
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
