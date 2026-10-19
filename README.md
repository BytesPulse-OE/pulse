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

Two Blade components let a user actually PICK those preferences —
`<x-pulse::theme-toggle>` and `<x-pulse::color-picker>`, see "Theme picker
components" below.

## Theme picker components

```blade
<x-pulse::theme-toggle
    name="appearance"
    value="system"
    :options="[
        'system' => ['label' => 'System', 'icon' => 'device-desktop'],
        'light' => ['label' => 'Light', 'icon' => 'sun'],
        'dark' => ['label' => 'Dark', 'icon' => 'moon'],
    ]"
/>
```

A segmented pill for the appearance preference. Pure CSS/radio-based, no JS
required — a real radio input per option, visually hidden, with the pill
look driven entirely by `peer-checked`. `options` and `value` both default
to light/dark/system if omitted.

```blade
<x-pulse::color-picker
    name="accent"
    value="indigo"
    :options="[
        'indigo' => ['label' => 'Indigo', 'class' => 'bg-indigo-500'],
        'teal' => ['label' => 'Teal', 'class' => 'bg-teal-500'],
        // ...
    ]"
/>
```

A "current swatch + label" trigger that expands into the full swatch grid
on click (needs `color-picker.js`, see "JavaScript" below — without it, the
grid is just always visible, which is still fully functional). Each
option's `class` is whatever CSS class paints that swatch — the component
doesn't know or care about Tailwind specifically, pass any class(es) that
produce a background color. An optional `check_class` per option overrides
the selected-checkmark color (defaults to `text-white`; useful for
light/warm swatches that need a dark checkmark to stay legible).

Both components emit real `name`/`value` radio inputs, so they work inside
an ordinary HTML form exactly like native `<input type="radio">` would —
wire them to whatever your settings page already posts.

## JavaScript

Four pieces of plain, dependency-free JS — no bundler of its own, so you
pull whichever you need into your own app's JS build:

```bash
php artisan vendor:publish --tag=pulse-js
```

This copies `select.js`, `sidebar.js`, `theme.js`, and `color-picker.js`
into `resources/js/vendor/pulse/`.

- **`select.js`** — the custom dropdown behind `<x-pulse::select>`.
- **`sidebar.js`** — mobile open/close behavior behind `<x-pulse::sidebar>`.
- **`color-picker.js`** — the collapse/expand behavior behind
  `<x-pulse::color-picker>` (see "Theme picker components" above).
- **`theme.js`** — the theming engine (see "Theming" above): a `PulseTheme`
  class that applies appearance/neutral/accent preferences to the
  `--pulse-*` CSS variables. It owns applying a preference, not picking one
  — pair it with `<x-pulse::theme-toggle>`/`<x-pulse::color-picker>` (or
  your own UI) and wire `setAppearance()`/`setNeutral()`/`setAccent()` to
  their `change` events:

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

  **Tailwind setup note:** `theme.js` builds its CSS variable references at
  runtime (`var(--color-${palette}-${shade})`), which Tailwind's build-time
  scanner can't see — it only emits a `--color-X-Y` variable when it finds
  a literal `bg-X-Y`/`text-X-Y` class somewhere in your scanned source. Add
  a safelist so every shade of every neutral/accent color is always
  available, not just the handful some unrelated class happens to use:

  ```css
  @source inline('{bg,text}-{slate,gray,zinc,neutral,stone}-{50,100,200,300,400,500,600,700,800,900,950}');
  @source inline('{bg,text}-{red,orange,amber,yellow,lime,green,emerald,teal,cyan,sky,blue,indigo,violet,purple,fuchsia,pink,rose}-{50,100,200,300,400,500,600,700,800,900,950}');
  ```

  Without this, only whatever shade some other class in your app already
  happens to use literally will actually render — every other
  palette/accent choice silently renders `--pulse-neutral-*`/`--pulse-
  accent*`-dependent backgrounds and text as transparent/invisible for any
  visitor who picks it.

Import whichever of the four you use from your own `resources/js/app.js`:

```js
import './vendor/pulse/select.js';
import './vendor/pulse/sidebar.js';
import './vendor/pulse/theme.js';
import './vendor/pulse/color-picker.js';
```

Every other component (button, card, input, and the rest) is markup/CSS
only — nothing to import for those.

## Media

```blade
<x-pulse::media
    src="/storage/media/sunset.jpg"
    alt="Sunset over the harbor"
    caption="Taken from the pier, August 2026"
    width="1600"
    height="900"
/>
```

Renders an `<img>` — or a `<figure>`/`<figcaption>` pair when `caption` is
given. Plain scalar props (`src`/`alt`/`caption`/`width`/`height`), same
precedent as `<x-pulse::avatar>`: this package doesn't know about a
media/attachment model, so a consuming app with one just maps its fields
onto these props at the call site, e.g.
`:src="$media->url()" :alt="$media->alt_text" :caption="$media->caption"`.

No default sizing classes are imposed — pass whatever `class` you need
(a full-width content image, a small cropped thumbnail, whatever); the
component only adds the caption/figure structure when asked for one.
`width`/`height` are passed through to the `<img>` tag itself (not for
display sizing — that's `class`'s job) so the browser can reserve the
right aspect ratio before the image loads, avoiding layout shift.

## Icons

The bundled icon set is an original set designed by the BytesPulse O.E.
team for this package.

## Overriding a component

Place a Blade view at the same relative path under your own application's
`resources/views/pulse/` directory to override a bundled component — it's
checked before the package's own version.

## License

MIT.
