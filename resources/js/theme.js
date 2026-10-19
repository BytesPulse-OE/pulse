/**
 * Pulse theming engine.
 *
 * Owns three independent preferences — appearance (light/dark/system),
 * neutral palette, and accent color — applied as the runtime CSS custom
 * properties every Pulse component reads (--pulse-neutral-50 through
 * --pulse-neutral-950, --pulse-accent / --pulse-accent-text /
 * --pulse-accent-contrast — see this package's README "Theming" section)
 * rather than by swapping class names, so components never need
 * per-theme markup.
 *
 * This class only owns APPLYING a preference, not any UI for picking one —
 * build your own settings page / swatch picker and call setAppearance()/
 * setNeutral()/setAccent(). Persistence (read/write) defaults to plain
 * localStorage but is fully overridable via the constructor, e.g. to skip
 * persistence inside a preview iframe, scope keys per-tenant, or persist
 * server-side instead.
 */

const PULSE_NEUTRALS = {
    slate: 'slate',
    gray: 'gray',
    zinc: 'zinc',
    neutral: 'neutral',
    stone: 'stone',
};

const PULSE_NEUTRAL_SHADES = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];

// Full accent spectrum, rainbow-ordered for a swatch picker. The three
// light/warm colors (amber, yellow, lime) read poorly with a white contrast
// color at any usable shade, so they get a lighter accent shade and a dark
// contrast color instead — every other entry follows the same
// light:600/dark:500 shape with a white contrast.
const PULSE_ACCENTS = {
    red: {
        light: { accent: 'var(--color-red-600)', text: 'var(--color-red-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-red-500)', text: 'var(--color-red-400)', contrast: 'var(--color-white)' },
    },
    orange: {
        light: { accent: 'var(--color-orange-600)', text: 'var(--color-orange-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-orange-500)', text: 'var(--color-orange-400)', contrast: 'var(--color-white)' },
    },
    amber: {
        light: { accent: 'var(--color-amber-500)', text: 'var(--color-amber-600)', contrast: 'var(--color-amber-950)' },
        dark: { accent: 'var(--color-amber-400)', text: 'var(--color-amber-400)', contrast: 'var(--color-amber-950)' },
    },
    yellow: {
        light: { accent: 'var(--color-yellow-500)', text: 'var(--color-yellow-600)', contrast: 'var(--color-yellow-950)' },
        dark: { accent: 'var(--color-yellow-400)', text: 'var(--color-yellow-400)', contrast: 'var(--color-yellow-950)' },
    },
    lime: {
        light: { accent: 'var(--color-lime-500)', text: 'var(--color-lime-600)', contrast: 'var(--color-lime-950)' },
        dark: { accent: 'var(--color-lime-400)', text: 'var(--color-lime-400)', contrast: 'var(--color-lime-950)' },
    },
    green: {
        light: { accent: 'var(--color-green-600)', text: 'var(--color-green-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-green-500)', text: 'var(--color-green-400)', contrast: 'var(--color-white)' },
    },
    emerald: {
        light: { accent: 'var(--color-emerald-600)', text: 'var(--color-emerald-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-emerald-500)', text: 'var(--color-emerald-400)', contrast: 'var(--color-white)' },
    },
    teal: {
        light: { accent: 'var(--color-teal-600)', text: 'var(--color-teal-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-teal-500)', text: 'var(--color-teal-400)', contrast: 'var(--color-white)' },
    },
    cyan: {
        light: { accent: 'var(--color-cyan-600)', text: 'var(--color-cyan-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-cyan-500)', text: 'var(--color-cyan-400)', contrast: 'var(--color-white)' },
    },
    sky: {
        light: { accent: 'var(--color-sky-600)', text: 'var(--color-sky-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-sky-500)', text: 'var(--color-sky-400)', contrast: 'var(--color-white)' },
    },
    blue: {
        light: { accent: 'var(--color-blue-600)', text: 'var(--color-blue-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-blue-500)', text: 'var(--color-blue-400)', contrast: 'var(--color-white)' },
    },
    indigo: {
        light: { accent: 'var(--color-indigo-600)', text: 'var(--color-indigo-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-indigo-500)', text: 'var(--color-indigo-400)', contrast: 'var(--color-white)' },
    },
    violet: {
        light: { accent: 'var(--color-violet-600)', text: 'var(--color-violet-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-violet-500)', text: 'var(--color-violet-400)', contrast: 'var(--color-white)' },
    },
    purple: {
        light: { accent: 'var(--color-purple-600)', text: 'var(--color-purple-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-purple-500)', text: 'var(--color-purple-400)', contrast: 'var(--color-white)' },
    },
    fuchsia: {
        light: { accent: 'var(--color-fuchsia-600)', text: 'var(--color-fuchsia-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-fuchsia-500)', text: 'var(--color-fuchsia-400)', contrast: 'var(--color-white)' },
    },
    pink: {
        light: { accent: 'var(--color-pink-600)', text: 'var(--color-pink-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-pink-500)', text: 'var(--color-pink-400)', contrast: 'var(--color-white)' },
    },
    rose: {
        light: { accent: 'var(--color-rose-600)', text: 'var(--color-rose-600)', contrast: 'var(--color-white)' },
        dark: { accent: 'var(--color-rose-500)', text: 'var(--color-rose-400)', contrast: 'var(--color-white)' },
    },
};

const DEFAULT_STORAGE_PREFIX = 'pulse-theme';

function defaultRead(key) {
    try {
        return window.localStorage.getItem(key);
    } catch (e) {
        return null;
    }
}

function defaultWrite(key, value) {
    try {
        window.localStorage.setItem(key, value);
    } catch (e) {
        // Ignored — theme falls back to defaults next load.
    }
}

export default class PulseTheme {
    #readFn;
    #writeFn;

    /**
     * @param {object} [options]
     * @param {string} [options.storagePrefix] - localStorage key prefix
     *   (default "pulse-theme"), so multiple consumers on one origin don't
     *   collide.
     * @param {(key: string) => string|null} [options.read] - override how a
     *   preference is read, e.g. to skip reading inside a preview iframe.
     * @param {(key: string, value: string) => void} [options.write] -
     *   override how a preference is persisted.
     * @param {{appearance?: string, neutral?: string, accent?: string}} [options.defaults]
     */
    constructor(options = {}) {
        const prefix = options.storagePrefix || DEFAULT_STORAGE_PREFIX;

        this.keys = {
            appearance: `${prefix}.appearance`,
            neutral: `${prefix}.neutral`,
            accent: `${prefix}.accent`,
        };

        this.#readFn = options.read || defaultRead;
        this.#writeFn = options.write || defaultWrite;

        const defaults = options.defaults || {};
        this.appearance = this.#readFn(this.keys.appearance) || defaults.appearance || 'system';
        this.neutral = this.#readFn(this.keys.neutral) || defaults.neutral || 'slate';
        this.accent = this.#readFn(this.keys.accent) || defaults.accent || 'indigo';
    }

    get neutrals() {
        return Object.keys(PULSE_NEUTRALS);
    }

    get accents() {
        return Object.keys(PULSE_ACCENTS);
    }

    setAppearance(value) {
        if (!['light', 'dark', 'system'].includes(value)) {
            return;
        }

        this.appearance = value;
        this.#writeFn(this.keys.appearance, value);
        this.applyAll();
    }

    setNeutral(name) {
        if (!PULSE_NEUTRALS[name]) {
            return;
        }

        this.neutral = name;
        this.#writeFn(this.keys.neutral, name);
        this.applyNeutral();
    }

    setAccent(name) {
        if (!PULSE_ACCENTS[name]) {
            return;
        }

        this.accent = name;
        this.#writeFn(this.keys.accent, name);
        this.applyAccent();
    }

    applyAll() {
        this.applyAppearance();
        this.applyNeutral();
        this.applyAccent();
    }

    applyAppearance() {
        document.documentElement.setAttribute('data-theme', this.#resolvedMode());
    }

    applyNeutral() {
        const palette = PULSE_NEUTRALS[this.neutral] || PULSE_NEUTRALS.slate;
        const root = document.documentElement;

        PULSE_NEUTRAL_SHADES.forEach((shade) => {
            root.style.setProperty(`--pulse-neutral-${shade}`, `var(--color-${palette}-${shade})`);
        });
    }

    applyAccent() {
        const entry = PULSE_ACCENTS[this.accent] || PULSE_ACCENTS.indigo;
        const values = this.#resolvedMode() === 'dark' ? entry.dark : entry.light;
        const root = document.documentElement;

        root.style.setProperty('--pulse-accent', values.accent);
        root.style.setProperty('--pulse-accent-text', values.text);
        root.style.setProperty('--pulse-accent-contrast', values.contrast);
    }

    #resolvedMode() {
        if (this.appearance !== 'system') {
            return this.appearance;
        }

        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
}
