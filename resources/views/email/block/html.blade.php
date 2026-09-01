@php
    $style = $block['style'] ?? [];
    $props = $block['props'] ?? [];

    $cssStyles = [];
    $cssStyles[] = "width: 100%";
    $cssStyles[] = "box-sizing: border-box";

    // Spaziature (Margini convertiti in pixel sicuri)
    if (isset($style['margin']['top'])) $cssStyles[] = "margin-top: " . ($style['margin']['top'] * 16) . "px";
    if (isset($style['margin']['bottom'])) $cssStyles[] = "margin-bottom: " . ($style['margin']['bottom'] * 16) . "px";
    if (isset($style['margin']['right'])) $cssStyles[] = "margin-right: " . ($style['margin']['right'] * 16) . "px";
    if (isset($style['margin']['left'])) $cssStyles[] = "margin-left: " . ($style['margin']['left'] * 16) . "px";

    // Spaziature (Padding convertiti in pixel sicuri)
    if (isset($style['padding']['top'])) $cssStyles[] = "padding-top: " . ($style['padding']['top'] * 16) . "px";
    if (isset($style['padding']['bottom'])) $cssStyles[] = "padding-bottom: " . ($style['padding']['bottom'] * 16) . "px";
    if (isset($style['padding']['right'])) $cssStyles[] = "padding-right: " . ($style['padding']['right'] * 16) . "px";
    if (isset($style['padding']['left'])) $cssStyles[] = "padding-left: " . ($style['padding']['left'] * 16) . "px";

    $inlineStyle = implode('; ', $cssStyles);
@endphp

<div style="{{ $inlineStyle }}">
    {!! $props['text'] ?? '' !!}
</div>