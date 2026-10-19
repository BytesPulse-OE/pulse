@props(['src', 'alt' => '', 'caption' => null, 'width' => null, 'height' => null])

{{--
    Renders an image with its attributes — same precedent as
    <x-pulse::avatar>: plain scalar props (src/alt/caption/width/height),
    not a bound Eloquent model, so this package stays decoupled from
    whatever media/attachment model a consuming app has. Pass whatever
    attribute values you have; a consuming app with its own media model
    just maps its fields onto these props at the call site, e.g.
    <x-pulse::media :src="$media->url()" :alt="$media->alt_text"
    :caption="$media->caption" :width="$media->width" :height="$media->height" />.

    width/height are passed through to the <img> tag when given — not for
    display sizing (that's CSS/the class attribute's job), but so the
    browser can reserve the right aspect ratio before the image loads,
    avoiding layout shift.

    No default sizing classes are imposed on the <img> itself — a content
    image, a full-width hero, and a small cropped grid thumbnail all need
    genuinely different `class` values, and merging a fixed default (e.g.
    `w-full h-auto`) via $attributes->class() would fight whatever the
    caller passes rather than letting it win cleanly. Pass whatever sizing
    classes you need; this component only adds the caption/figure
    structure when asked for one.
--}}
@if ($caption)
    <figure>
        <img src="{{ $src }}" alt="{{ $alt }}" @if ($width) width="{{ $width }}" @endif @if ($height) height="{{ $height }}" @endif {{ $attributes }}>
        <figcaption class="mt-2 text-sm text-(--pulse-neutral-500) dark:text-(--pulse-neutral-400)">
            {{ $caption }}
        </figcaption>
    </figure>
@else
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        @if ($width) width="{{ $width }}" @endif
        @if ($height) height="{{ $height }}" @endif
        {{ $attributes }}
    >
@endif
