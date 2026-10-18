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

## Icons

The bundled icon set is an original set designed by the BytesPulse O.E.
team for this package.

## Overriding a component

Place a Blade view at the same relative path under your own application's
`resources/views/pulse/` directory to override a bundled component — it's
checked before the package's own version.

## License

MIT.
